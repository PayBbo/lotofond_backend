<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Http\Services\Parse\BidderService;
use App\Http\Services\Parse\DescriptionExtractsService;
use App\Http\Services\Parse\FilesService;
use App\Http\Services\Parse\SoapWrapperService;
use App\Http\Services\Parse\TradeService;
use App\Models\Auction;
use App\Models\AuctionType;
use App\Models\Bidder;
use App\Models\LotFile;
use App\Models\SroAu;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Midnite81\Xml2Array\Xml2Array;

class BiddingInvitation extends TradeMessage
{
    public function response($tradePlace, $trade)
    {
        try {
            $invitation = $this->invitation;
            $prefix = $this->prefix;

            /*Парсим должника. Если его инн пустое - торги не сохраняются.*/

            $debtor = $invitation[$prefix . 'Debtor'];
            if (array_key_exists($prefix . 'DebtorPerson', $debtor)) {
                $debtor = $debtor[$prefix . 'DebtorPerson']['@attributes'];
                $debtor_type = 'person';
                $codeType = 'PersonInn';
            } elseif (array_key_exists($prefix . 'DebtorCompany', $debtor)) {
                $debtor = $debtor[$prefix . 'DebtorCompany']['@attributes'];
                $debtor_type = 'company';
                $codeType = 'CompanyInn';
            }
            if (array_key_exists('INN', $debtor) && $debtor['INN'] !== "" && !is_null($debtor['INN'])) {
                $soapWrapper = new SoapWrapper();
                $service = new SoapWrapperService($soapWrapper);
                $debtor_data = get_object_vars($service->searchDebtorByCode($codeType, $debtor['INN']));
                if (array_key_exists('DebtorPerson', $debtor_data)) {
                    if(gettype($debtor_data['DebtorPerson']) == 'array'){
                        $debtor = $debtor_data['DebtorPerson'];
                        if(gettype($debtor) == 'array'){
                            $debtor = $debtor[count($debtor)-1];
                        }
                    }else {
                        $debtor = get_object_vars($debtor_data['DebtorPerson']);
                    }
                } elseif (array_key_exists('DebtorCompany', $debtor_data)) {
                    if(gettype($debtor_data['DebtorCompany']) == 'array'){
                        $debtor = $debtor_data['DebtorCompany'];
                        if(gettype($debtor) == 'array'){
                            $debtor = $debtor[count($debtor)-1];
                        }
                    }else {
                        $debtor = get_object_vars($debtor_data['DebtorCompany']);
                    }
                }
                if(!array_key_exists('INN', $debtor)){
                    $bidderParse = new BidderService('debtor', get_object_vars(array_pop($debtor))['INN'], $debtor_type);
                }else {
                    $bidderParse = new BidderService('debtor', $debtor['INN'], $debtor_type);
                }
                $debtor = $bidderParse->saveBidder($debtor);
            } else {
                return null;
            }

            /*Парсим арбитражного управляющего, он может быть не задан*/

            $arbitr_manager = null;
            if (array_key_exists($prefix . 'ArbitrManager', $invitation)) {
                $arbitr_manager = $invitation[$prefix . 'ArbitrManager']['@attributes'];
                $manager_type = 'person';
            } elseif (array_key_exists($prefix . 'CompanyBankrCommis', $invitation)) {
                $arbitr_manager = $invitation[$prefix . 'CompanyBankrCommis']['@attributes'];
                $manager_type = 'company';
            }
            if (array_key_exists('INN', $arbitr_manager) && $arbitr_manager['INN'] != "" && !is_null($arbitr_manager['INN'])) {
                $managerParse = new BidderService('arbitrationManager', $arbitr_manager['INN'], $manager_type);
                $arbitr_manager = $managerParse->saveBidder($arbitr_manager);
            }

            /*Парсим организатора торгов, он может быть не задан*/

            $trade_organizer = null;
            if (array_key_exists($prefix . 'TradeOrganizer', $invitation)) {
                $organizer = $invitation[$prefix . 'TradeOrganizer'];
                if (array_key_exists($prefix . 'TradeOrganizerPerson', $organizer)) {
                    $org = $organizer[$prefix . 'TradeOrganizerPerson']['@attributes'];
                    $org_type = 'person';
                } else {
                    $org = $organizer[$prefix . 'TradeOrganizerCompany']['@attributes'];
                    $org_type = 'company';
                }
                if (array_key_exists('INN', $org) && $org['INN'] != "" && !is_null($org['INN'])) {
                    $orgParse = new BidderService('organizer', $org['INN'], $org_type);
                    $trade_organizer = $orgParse->saveBidder($org);
                }
            }


            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if (!$auction) {
                $auction = new Auction();
            }
            $data = $invitation[$prefix . 'TradeInfo'];
            $auction->id_efrsb = array_key_exists($prefix .'IDEFRSB', $invitation) ? $invitation[$prefix . 'IDEFRSB'] : NULL;
            $auction->id_external = array_key_exists('ID_External', $trade) ? $trade->ID_External : NULL;
            $auction->guid = array_key_exists('GUID', $trade) ? $trade->GUID : NULL;
            $auction->trade_place_id = $tradePlace;
            $auction->trade_id = $invitation['@attributes']['TradeId'];
            $auction->publish_date =$this->parseDate($invitation['@attributes']['EventTime']);
            $auction->debtor_id = $debtor->id;
            $auction->arbitr_manager_id = is_null($arbitr_manager) ?: $arbitr_manager->id;
            $auction->company_trade_organizer_id = is_null($trade_organizer) ?: $trade_organizer->id;
            $auction->auction_type_id = AuctionType::where('title', $data['@attributes']['AuctionType'])->first()->id;
            $auction->result_date = array_key_exists($prefix . 'CloseForm', $data) ? $this->parseDate($data[$prefix . 'CloseForm']['@attributes']['TimeResult']) : NULL;
            $auction->event_start_date = array_key_exists($prefix . 'OpenForm', $data) ? $this->parseDate($data[$prefix . 'OpenForm']['@attributes']['TimeBegin']) : NULL;
            $auction->event_end_date = array_key_exists($prefix . 'OpenForm', $data) && array_key_exists('TimeEnd', $data[$prefix . 'OpenForm']) ? $this->parseDate($data[$prefix . 'OpenForm']['TimeEnd']) : NULL;
            $auction->application_start_date = $this->parseDate($data[$prefix . 'Application']['@attributes']['TimeBegin']);
            $auction->application_end_date = $this->parseDate($data[$prefix . 'Application']['@attributes']['TimeEnd']);
            $auction->application_rules = $data[$prefix . 'Application'][$prefix.'Rules'];
            if(array_key_exists($prefix . 'DatePublishSMI', $data) && gettype($data[$prefix . 'DatePublishSMI'] ) !== 'array') {
                $auction->date_publish_smi =  $data[$prefix . 'DatePublishSMI'];
            }
            if(array_key_exists($prefix . 'DatePublishEFIR', $data) && gettype($data[$prefix . 'DatePublishEFIR'] ) !== 'array') {
                $auction->date_publish_efir =  $data[$prefix . 'DatePublishEFIR'];
            }
            $auction->price_form = $data['@attributes']['FormPrice'] == 'OpenForm' ? 'open' : 'close';
            if (array_key_exists($prefix . 'LegalCase', $invitation)) {
                $auction->case_number = $invitation[$prefix . 'LegalCase']['@attributes']['CaseNumber'];
                $auction->court = $invitation[$prefix . 'LegalCase']['@attributes']['CourtName'];
            }
            $auction->save();
            $files = null;
            $images = null;
            if (array_key_exists($prefix . 'Attach', $data)) {
                if (mb_stripos($data[$prefix . 'Attach'][$prefix . 'FileName'], 'фото') !== false) {
                    $parseFiles = new FilesService();
                    $images = $parseFiles->parseFiles($data, $auction, $prefix, true);
                } else {
                    $parseFiles = new FilesService();
                    $files = $parseFiles->parseFiles($data, $auction, $prefix);
                }

            }
            foreach ($data[$prefix . 'LotList'] as $lot) {
                if (array_key_exists('0', $lot) || array_key_exists($prefix.'Lot', $lot)) {
                    foreach ($lot as $value) {
                        $tradeService = new TradeService($auction, $value, $prefix, null, $files, $images);
                        $newLot = $tradeService->saveLot();
                        $tradeMessage = $this->createNotification($newLot->id, $invitation['@attributes']['EventTime']);
                    }
                } else {
                    $tradeService = new TradeService($auction, $lot, $prefix, null,  $files, $images);
                    $newLot = $tradeService->saveLot();
                    $tradeMessage = $this->createNotification($newLot->id, $invitation['@attributes']['EventTime']);
                }
            }
            $auction = Auction::find($auction->id);
            $this->parseDataFromAuction($auction);

        } catch (\Exception $e) {
            logger('ParseTradesExc: ' . $e);
            logger($invitation);
        }

    }

    public function parseDataFromAuction($auction){
        $id = $auction->id_efrsb;
        if (!is_null($id)) {
            $soapWrapper = new SoapWrapper();
            $service = new SoapWrapperService($soapWrapper);
            $xml = $service->getMessageContent($id);
            $xml = Xml2Array::create($xml)->toArray();
            try {
                $text = null;
                $lots = [];
                $tmp_type = null;
                if (array_key_exists('Auction', $xml['MessageInfo'])) {
                    $tmp_type = 'Auction';
                } elseif (array_key_exists('ChangeAuction', $xml['MessageInfo'])) {
                    $tmp_type = 'ChangeAuction';
                } elseif (array_key_exists('Auction2', $xml['MessageInfo'])) {
                    $tmp_type = 'Auction2';
                }
                if (!is_null($tmp_type)) {
                    $lots = $xml['MessageInfo'][$tmp_type]['LotTable']['AuctionLot'];
                    $text = $xml['MessageInfo'][$tmp_type]['Text'];
                }
                $descriptionExtracts = new DescriptionExtractsService();
                $lotOrders = [];
                if (array_key_exists('Order', $lots)) {
                    $auctionLot = $lots;
                    $lotOrders[] = $auctionLot['Order'];
                    $descriptionExtracts->processDescriptionFromAuction($auctionLot, $text, $auction, true);
                } else {
                    foreach ($lots as $auctionLot) {
                        $lotOrders[] = $auctionLot['Order'];
                        $descriptionExtracts->processDescriptionFromAuction($auctionLot, $text, $auction);
                    }
                }
                $this->parseBiddersAndFilesFromAuction($xml, $auction, $lotOrders);
            } catch (\Exception $e) {
                logger($e);
                logger($auction->id);
                logger($xml);
            }
        }
    }

    public function parseBiddersAndFilesFromAuction($xml, $auction, $lotOrders)
    {
        $publisher = $xml['Publisher'];
        $bidder = Bidder::where('inn', $publisher['Inn'])->first();
        if ($bidder) {
            if (array_key_exists('Email', $publisher) && isset($publisher['Email'])) {
                $bidder->email = $publisher['Email'];
            }
            if (array_key_exists('Snils', $publisher) && isset($publisher['Snils'])) {
                $bidder->snils = $publisher['Snils'];
            }
            if (array_key_exists('Ogrn', $publisher) && isset($publisher['Ogrn'])) {
                $bidder->ogrn = $publisher['Ogrn'];
            }
            if (array_key_exists('Ogrnip', $publisher) && isset($publisher['Ogrnip'])) {
                $bidder->ogrnip = $publisher['Ogrnip'];
            }
            if (array_key_exists('CorrespondenceAddress', $publisher) && isset($publisher['CorrespondenceAddress'])) {
                $bidder->correspondence_address = $publisher['CorrespondenceAddress'];
            }
            if (array_key_exists('Sro', $publisher) && isset($publisher['Snils'])) {
                $sro = $bidder->sroAu;
                if (!$sro) {
                    $sro = new SroAu();
                    $bidder->sro_au_id = $sro->id;
                }
                if (array_key_exists('Name', $publisher['Sro']) && isset($publisher['Sro']['Name'])) {
                    $sro->name = $publisher['Sro']['Name'];
                }
                if (array_key_exists('Ogrn', $publisher['Sro']) && isset($publisher['Sro']['Ogrn'])) {
                    $sro->ogrn = $publisher['Sro']['Ogrn'];
                }
                if (array_key_exists('Inn', $publisher['Sro']) && isset($publisher['Sro']['Inn'])) {
                    $sro->inn = $publisher['Sro']['Inn'];
                }
                if (array_key_exists('Address', $publisher['Sro']) && isset($publisher['Sro']['Address'])) {
                    $sro->address = $publisher['Sro']['Address'];
                }
                $sro->save();
            }
            $bidder->save();
        }
        $lots = null;
        if(count($lotOrders) > 1){
            $lots = $auction->lots->whereIn('number', $lotOrders);
        }else{
            if(count($lotOrders) == 1 && $auction->lots->count() == 1){
                $lots = $auction->lots;
            }
        }
        if(!is_null($lots)) {
            $files = [];
            $parsedFiles = null;
            if (array_key_exists('MessageURLList', $xml) && array_key_exists('MessageURL', $xml['MessageURLList'])) {
                $urls = $xml['MessageURLList']['MessageURL'];
                if (array_key_exists('@attributes', $urls)) {
                    $files[] = ['filename' => $urls['@attributes']['URLName'], 'link' => $urls['@attributes']['URL']];
                } else {
                    foreach ($urls as $url) {
                        $files[] = ['filename' => $url['@attributes']['URLName'], 'link' => $url['@attributes']['URL']];
                    }
                }
                $fileService = new FilesService();
                $parsedFiles = $fileService->downloadFileByLink($files, $auction->id);
            }
            if(!is_null($parsedFiles)){
                foreach($lots as $lot){
                    if (count($parsedFiles['files']) > 0) {
                        foreach ($parsedFiles['files'] as $file) {
                            $this->saveFiles($file, 'file', $lot);
                        }
                    }
                    if (count($parsedFiles['images']) > 0) {
                        foreach ($parsedFiles['images'] as $image) {
                            $this->saveFiles($image, 'image', $lot);
                        }
                    }
                }
            }
        }
    }

    public function saveFiles($file, $type, $lot)
    {
        if (!LotFile::where(['url' => json_encode($file), 'lot_id' => $lot->id, 'type' => $type])->exists()) {
            LotFile::create([
                'url' => json_encode($file),
                'type' => $type,
                'lot_id' => $lot->id
            ]);
        }
    }


}
