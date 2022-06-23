<?php

namespace App\Http\Services\Parse;

use App\Models\Auction;
use App\Models\AuctionType;
use App\Models\Status;
use App\Models\TradeMessage;
use Midnite81\Xml2Array\Xml2Array;
use function logger;

class GetTradeMessageContent
{
    protected $invitation;
    protected $prefix;
    protected $type;
    protected $xml;
    protected $messageId;

    public function __construct($xml, $type)
    {
        try {
            $xml = Xml2Array::create($xml)->toArray();
            $this->type = $type;
            $this->xml = $xml;
            $key = preg_grep('/:Body/', array_keys($xml));
            if($type == 'BiddingProcess'){
                $type .='Info';
            }
            if (array_key_exists('ns1:Set' . $type, $xml[$key[0]])) {
                $this->invitation = $xml[$key[0]]['ns1:Set' .$type]['ns1:' . $type];
                $this->prefix = 'ns1:';
            } else {
                $this->invitation = $xml[$key[0]]['Set' . $type][$type];
                $this->prefix = '';
            }
        }catch(\Exception $e){
            logger($this->xml);
        }
    }

    public function switchMessageType($tradePlace, $trade, $id)
    {
        if (TradeMessage::where('number', $id)->exists()) {
            return;
        }
        $this->messageId = $id;
        switch ($this->type) {
            case 'BiddingInvitation':
            {
                $this->biddingInvitationResponse($tradePlace, $trade);
                break;
            }
            case 'BiddingProcessInfo':
            {
                $this->biddingProcessInfo();
                break;
            }
            case 'ApplicationSessionStatistic':
            {
                $this->applicationSessionStatistic();
                break;
            }
            case 'AnnulmentMessage':
            {
                $this->annulmentMessage();
                break;
            }

            case ($this->type == 'BiddingEnd' || $this->type == 'BiddingStart'
                || $this->type == 'ApplicationSessionEnd' || $this->type == 'ApplicationSessionStart'):
            {
                $this->applicationSession();
                break;
            }
            case ($this->type == 'BiddingCancel' || $this->type == 'BiddingFail'
                || $this->type == 'BiddingPause' || $this->type == 'BiddingResume'):
            {
                $this->biddingStatusWithReason();
                break;
            }
            case 'NewTradeOrganizer':
            {
                $this->newTradeOrganizer();
                break;
            }
            case 'BiddingNewTerm':
            {
                $this->biddingNewTerm();
                break;
            }
        }

    }

    public function biddingInvitationResponse($tradePlace, $trade)
    {
        try {
            $invitation =  $this->invitation;
            $prefix =  $this->prefix;

            /*Парсим должника. Если его инн пустое - торги не сохраняются.*/

            $debtor = $invitation[$prefix . 'Debtor'];
            if (array_key_exists($prefix . 'DebtorPerson', $debtor)) {
                $debtor = $debtor[$prefix . 'DebtorPerson']['@attributes'];
                $debtor_type = 'person';
            } elseif(array_key_exists($prefix . 'DebtorCompany', $debtor)){
                $debtor = $debtor[$prefix . 'DebtorCompany']['@attributes'];
                $debtor_type = 'company';
            }
            if(array_key_exists('INN', $debtor)&&  $debtor['INN'] != "" && !is_null( $debtor['INN'])){
                $bidderParse = new BidderService('debtor', $debtor['INN'], $debtor_type);
                $debtor = $bidderParse->saveBidder($debtor);
            }else{
                return;
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
            if(array_key_exists('INN',$arbitr_manager)&&  $arbitr_manager['INN'] != "" && !is_null( $arbitr_manager['INN'])){
                $managerParse = new BidderService('arbitr_manager', $arbitr_manager['INN'], $manager_type);
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
                if(array_key_exists('INN',$org)&&  $org['INN'] != "" && !is_null($org['INN'])){
                    $orgParse = new BidderService('trade_organizer', $org['INN'], $org_type);
                    $trade_organizer = $orgParse->saveBidder($org);
                }
            }


            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if (!$auction) {
                $auction = new Auction();
            }
            $data = $invitation[$prefix . 'TradeInfo'];
            $auction->id_efrsb = array_key_exists('ID_EFRSB', $trade) ? $trade->ID_EFRSB : NULL;
            $auction->id_external = array_key_exists('ID_External', $trade) ? $trade->ID_External : NULL;
            $auction->guid = array_key_exists('GUID', $trade) ? $trade->GUID : NULL;
            $auction->trade_place_id = $tradePlace;
            $auction->trade_id = $invitation['@attributes']['TradeId'];
            $auction->publish_date = $invitation['@attributes']['EventTime'];
            $auction->debtor_id = $debtor->id;
            $auction->arbitr_manager_id = is_null($arbitr_manager) ?: $arbitr_manager->id;
            $auction->company_trade_organizer_id = is_null($trade_organizer) ?: $trade_organizer->id;
            $auction->auction_type_id = AuctionType::where('title', $data['@attributes']['AuctionType'])->first()->id;
            $auction->result_date = array_key_exists($prefix . 'CloseForm', $data) ? $data[$prefix . 'CloseForm']['@attributes']['TimeResult'] : NULL;
            $auction->event_start_date = array_key_exists($prefix . 'OpenForm', $data) ? $data[$prefix . 'OpenForm']['@attributes']['TimeBegin'] : NULL;
            $auction->event_end_date = array_key_exists($prefix . 'OpenForm', $data) && array_key_exists('TimeEnd', $data[$prefix . 'OpenForm']) ? $data[$prefix . 'OpenForm']['TimeEnd'] : NULL;
            $auction->application_start_date = $data[$prefix . 'Application']['@attributes']['TimeBegin'];
            $auction->application_end_date = $data[$prefix . 'Application']['@attributes']['TimeEnd'];
            $auction->date_publish_smi = array_key_exists($prefix. 'DatePublishSMI', $data) ? $data[$prefix. 'DatePublishSMI'] : NULL;
            $auction->date_publish_efir = array_key_exists($prefix. 'DatePublishEFIR', $data) ? $data[$prefix. 'DatePublishEFIR'] : NULL;
            $auction->price_form = $data['@attributes']['FormPrice'] == 'OpenForm' ? 'open' : 'close';
            if (array_key_exists($prefix . 'LegalCase', $invitation)) {
                $auction->case_number = $invitation[$prefix . 'LegalCase']['@attributes']['CaseNumber'];
                $auction->court = $invitation[$prefix . 'LegalCase']['@attributes']['CourtName'];
            }
            $auction->save();
            $files = null;
            $images = null;
           /* if (array_key_exists($prefix . 'Attach', $data)) {
                if (mb_stripos($data[$prefix . 'Attach'][$prefix . 'FileName'], 'фото') !== false) {
                    $images = new FilesService($data, $auction, $prefix, true);
                } else {
                    $files = new FilesService($data, $auction, $prefix);
                }

            }*/
            foreach ($data[$prefix . 'LotList'] as $lot) {
                if (array_key_exists('0', $lot) || array_key_exists('Lot', $lot)) {
                    foreach ($lot as $value) {
                        $tradeService = new TradeService($auction, $value, $prefix, $files, $images);
                        $lot = $tradeService->saveLot();
                        $this->createNotification($lot->id, $invitation['@attributes']['EventTime']);
                    }
                } else {
                    $tradeService = new TradeService($auction, $lot, $prefix, $files, $images);
                    $lot = $tradeService->saveLot();
                    $this->createNotification($lot->id, $invitation['@attributes']['EventTime']);
                }
            }

        } catch (\Exception $e) {
            logger('ParseTradesExc: ' . $e);
            logger($invitation);
        }

    }

    public function applicationSessionStatistic()
    {
        $invitation =  $this->invitation;
        $prefix =  $this->prefix;
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction && array_key_exists($prefix . 'Attach', $invitation)) {
                $url = new FilesService($invitation, $auction, $prefix);
                $auction_lot = $auction->lots->where('number', $invitation[$prefix . 'LotList'][$prefix . 'LotStatistic']['@attributes']['LotNumber'])->first();
                if ($auction_lot) {
                    $files[] = $url;
                    $auction_lot->files = $files;
                    $auction_lot->save();
                }

            }
        } catch (\Exception $e) {
            logger('applicationSessionStatistic: ' . $e);
            logger($invitation);
        }

    }

    public function applicationSession()
    {
        $invitation =  $this->invitation;
        $prefix =  $this->prefix;
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                if (array_key_exists($prefix . 'LotList', $invitation)) {
                    if (count($invitation[$prefix . 'LotList'][$prefix . 'LotInfo']) > 1) {
                        foreach ($invitation[$prefix . 'LotList'][$prefix . 'LotInfo'] as $lot) {
                            $auction_lot = $auction->lots->where('number', $lot['@attributes']['LotNumber'])->first();
                            if ($auction_lot) {
                                $auction_lot->status_id = Status::where('code', $this->type)->first()['id'];
                                $auction_lot->save();
                                $this->createNotification($auction_lot->id, $lot['@attributes']['EventTime']);
                            }
                        }
                    } else {
                        $auction_lot = $auction->lots->where('number', $invitation[$prefix . 'LotList'][$prefix . 'LotInfo']['@attributes']['LotNumber'])->first();
                        if ($auction_lot) {
                            $auction_lot->status_id = Status::where('code', $this->type)->first()['id'];
                            $auction_lot->save();
                            $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime']);
                        }
                    }
                } else {
                    foreach ($auction->lots as $lot) {
                        $lot->status_id = Status::where('code', $this->type)->first()['id'];
                        $lot->save();
                        $this->createNotification($lot->id, $invitation['@attributes']['EventTime']);
                    }
                }
            }
        } catch (\Exception $e) {
            logger('parseTradeStatusExc: ' . $e);
            logger($invitation);
        }

    }

    public function biddingProcessInfo()
    {
        $invitation =  $this->invitation;
        $prefix =  $this->prefix;
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                logger('BIDDINGPROCESSINFO');
                $auction_lot = $auction->lots->where('number', $invitation[$prefix . 'PriceInfo']['LotNumber'])->first();
                if ($auction_lot) {
                    $price = $invitation[$prefix . 'PriceInfo']['NewPrice'];
                    $value = 'Изменение цены';
                    if ($auction_lot->price < $price) {
                        $auction_lot->price_state = 'low';
                        $value = 'Понижение цены';
                    } elseif ($auction_lot->price > $price) {
                        $auction_lot->price_state = 'up';
                        $value = 'Повышение цены';
                    }
                    $auction_lot->price = $price;
                    $auction_lot->save();
                    $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'], $value);
                }
            }

        } catch (\Exception $e) {
            logger('biddingProcessInfo(Exc: ' . $e);
            logger($this->xml);
        }
    }

    public function annulmentMessage()
    {
        $invitation =  $this->invitation;
        $prefix =  $this->prefix;
        logger('ANNULMENT');
        logger($invitation);
        try {

        } catch (\Exception $e) {
            logger('annulmentMessageExc: ' . $e);
            logger($invitation);
        }
    }

    public function biddingStatusWithReason()
    {
        $invitation =  $this->invitation;
        $prefix =  $this->prefix;
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                $url = null;
                if (array_key_exists($prefix . 'Attach', $invitation)) {
                    $url = new FilesService($invitation, $auction, $prefix);
                }
                if (array_key_exists($prefix . 'LotList', $invitation)) {
                    $auction_lot = $auction->lots->where('number', $invitation[$prefix . 'LotList'][$prefix . 'BiddingStateLotInfo']['@attributes']['LotNumber'])->first();
                    if ($auction_lot) {
                        $auction_lot->status_id = Status::where('code', $this->type)->first()['id'];
                        if (!is_null($url)) {
                            $files = $auction_lot->files;
                            $files[] = $url;
                            $auction_lot->files = $files;
                        }
                        $auction_lot->save();
                        $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'],
                            $invitation[$prefix . 'LotList'][$prefix . 'BiddingStateLotInfo']['@attributes']['Reason']);
                    }

                } else {
                    foreach ($auction->lots as $lot) {
                        $lot->status_id = Status::where('code', $this->type)->first()['id'];
                        if (!is_null($url)) {
                            $files = $lot->files;
                            $files[] = $url;
                            $lot->files = $files;
                        }
                        $lot->save();
                        $this->createNotification($lot->id, $invitation['@attributes']['EventTime'],
                            $invitation['@attributes']['Reason']);
                    }
                }
            }
        } catch (\Exception $e) {
            logger('biddingStatusWithReasonExc: ' . $e);
            logger($invitation);
        }
    }

    public function newTradeOrganizer()
    {
        $invitation =  $this->invitation;
        $prefix =  $this->prefix;
        logger('NEWTRADEORG');
        logger($invitation);
        try {

        } catch (\Exception $e) {
            logger('newTradeOrganizerExc: ' . $e);
            logger($invitation);
        }
    }

    public function biddingNewTerm()
    {
        $invitation =  $this->invitation;
        $prefix =  $this->prefix;
        logger($invitation);
        try {

        } catch (\Exception $e) {
            logger('biddingNewTermExc: ' . $e);
            logger($invitation);
        }
    }



    public function createNotification($lot, $date, $value = null, $param=null, $param_type=null)
    {
        TradeMessage::create([
            'lot_id' => $lot,
            'value' => is_null($value) ? Status::where('code', $this->type)->first()['value'] : $value,
            'number' => $this->messageId,
            'date' => $date,
            'param'=>$param,
            'param_type'=>$param_type
        ]);
    }


}
