<?php

namespace App\Http\Services;

use App\Models\ArbitrManager;
use App\Models\Auction;
use App\Models\AuctionType;
use App\Models\Category;
use App\Models\CompanyTradeOrganizer;
use App\Models\Debtor;
use App\Models\Lot;
use App\Models\SroAu;
use App\Models\Status;
use App\Models\TradeMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Midnite81\Xml2Array\Xml2Array;

class GetTradeMessageContent
{
    protected $xml;

    public function __construct($xml)
    {
        $this->xml = Xml2Array::create($xml)->toArray();
    }

    public function getContent($type)
    {
        $key = preg_grep('/:Body/', array_keys($this->xml));
        if (array_key_exists('ns1:Set' . $type, $this->xml[$key[0]])) {
            $invitation = $this->xml[$key[0]]['ns1:Set' . $type]['ns1:' . $type];
            $prefix = 'ns1:';
        } else {
            $invitation = $this->xml[$key[0]]['Set' . $type][$type];
            $prefix = '';
        }
        return [$invitation, $prefix];
    }

    public function switchMessageType($type, $tradePlace, $trade, $id)
    {
        if (TradeMessage::where('number', $id)->exists()) {
            return;
        }
        switch ($type) {
            case 'BiddingInvitation':
            {
                $this->biddingInvitationResponse($tradePlace, $trade);
                break;
            }
            case 'BiddingProcessInfo':
            {
                $this->biddingProcessInfo($type, $id);
                break;
            }
            case 'ApplicationSessionStatistic':
            {
                $this->applicationSessionStatistic();
                break;
            }
            case 'AnnulmentMessage':
            {
                $this->annulmentMessage($type, $id);
                break;
            }

            case ($type == 'BiddingEnd' || $type == 'BiddingStart' || $type == 'ApplicationSessionEnd' || $type == 'ApplicationSessionStart'):
            {
                $this->applicationSession($type, $id);
                break;
            }
            case ($type == 'BiddingCancel' || $type == 'BiddingFail' || $type == 'BiddingPause' || $type == 'BiddingResume'):
            {
                $this->biddingStatusWithReason($type, $id);
                break;
            }
            case 'NewTradeOrganizer':
            {
                $this->newTradeOrganizer($type, $id);
                break;
            }
            case 'BiddingNewTerm':
            {
                $this->biddingNewTerm($type, $id);
                break;
            }


        }

    }

    public function biddingInvitationResponse($tradePlace, $trade)
    {
        try {
            $content = $this->getContent('BiddingInvitation');
            $invitation = $content[0];
            $prefix = $content[1];
            $debtor = $invitation[$prefix . 'Debtor'];
            if (array_key_exists($prefix . 'DebtorPerson', $debtor)) {
                $name = $debtor[$prefix . 'DebtorPerson']['@attributes']['LastName'] . ' ' . $debtor[$prefix . 'DebtorPerson']['@attributes']['FirstName'];
                if (array_key_exists('MiddleName', $debtor[$prefix . 'DebtorPerson']['@attributes'])) {
                    $name .= ' ' . $debtor[$prefix . 'DebtorPerson']['@attributes']['MiddleName'];
                }
                $debtor_exists = Debtor::where('name', $name)->first();
                if (!$debtor_exists) {
                    $debtor_exists = new Debtor();
                    $debtor_exists->name = $name;
                    $debtor_exists->inn = array_key_exists('INN', $debtor[$prefix . 'DebtorPerson']['@attributes']) ? $debtor[$prefix . 'DebtorPerson']['@attributes']['INN'] : NULL;
                    $debtor_exists->save();

                }
            } else {
                $debtor_exists = Debtor::where('inn', $debtor[$prefix . 'DebtorCompany']['@attributes']['INN'])->first();
                if (!$debtor_exists) {
                    $debtor_exists = new Debtor();
                    $debtor_exists->name = $debtor[$prefix . 'DebtorCompany']['@attributes']['FullName'];
                    $debtor_exists->short_name = $debtor[$prefix . 'DebtorCompany']['@attributes']['ShortName'];
                    $debtor_exists->inn = $debtor[$prefix . 'DebtorCompany']['@attributes']['INN'];
                    $debtor_exists->ogrn = $debtor[$prefix . 'DebtorCompany']['@attributes']['OGRN'];
                    $debtor_exists->save();
                }
            }
            $arbitr_manager = null;
            if (array_key_exists($prefix . 'ArbitrManager', $invitation)) {
                $manager = $invitation[$prefix . 'ArbitrManager']['@attributes'];
                $arbitr_manager = ArbitrManager::where('inn', $manager['INN'])->first();
                if (!$arbitr_manager) {
                    $sro = null;
                    if (array_key_exists('SROName', $manager)) {
                        $sro = SroAu::where('name', $manager['SROName'])->first();
                        if (!$sro) {
                            $sro = SroAu::create(['name' => $manager['SROName']]);
                        }
                    }
                    $arbitr_manager = ArbitrManager::create([
                        'name' => $manager['LastName'] . ' ' . $manager['FirstName'],
                        'inn' => $manager['INN'],
                        'sro_au_id' => is_null($sro) ?: $sro->id
                    ]);
                    if (array_key_exists('MiddleName', $manager)) {
                        $arbitr_manager->name .= ' ' . $manager['MiddleName'];
                        $arbitr_manager->save();
                    }
                }
            } elseif (array_key_exists($prefix . 'CompanyBankrCommis', $invitation)) {
                $manager = $invitation[$prefix . 'CompanyBankrCommis']['@attributes'];
                $arbitr_manager = ArbitrManager::where('inn', $manager['INN'])->first();
                if (!$arbitr_manager) {
                    $arbitr_manager = ArbitrManager::create([
                        'name' => $manager['ShortName'],
                        'inn' => $manager['INN']
                    ]);
                }
            }
            $trade_organizer = null;
            if (array_key_exists($prefix . 'TradeOrganizer', $invitation)) {
                $organizer = $invitation[$prefix . 'TradeOrganizer'];
                if (array_key_exists($prefix . 'TradeOrganizerPerson', $organizer)) {
                    $org = $organizer[$prefix . 'TradeOrganizerPerson']['@attributes'];
                    $trade_organizer = CompanyTradeOrganizer::where('inn', $org['INN'])->first();
                    if (!$trade_organizer) {
                        $trade_organizer = CompanyTradeOrganizer::create([
                            'name' => $org['LastName'] . ' ' . $org['FirstName'] . ' ' . $org['LastName'],
                            'inn' => $org['INN']
                        ]);
                        if (array_key_exists('MiddleName', $org)) {
                            $trade_organizer->name .= ' ' . $org['MiddleName'];
                            $trade_organizer->save();
                        }
                    }
                } else {
                    $org = $organizer[$prefix . 'TradeOrganizerCompany']['@attributes'];
                    $trade_organizer = CompanyTradeOrganizer::where('inn', $org['INN'])->first();
                    if (!$trade_organizer) {
                        $trade_organizer = CompanyTradeOrganizer::create([
                            'name' => $org['FullName'],
                            'short_name' => $org['ShortName'],
                            'inn' => $org['INN'],
                            'ogrn' => $org['OGRN']
                        ]);
                    }
                }
            }
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if (!$auction) {
                $auction = new Auction();
            }
            $auction->id_efrsb = array_key_exists('ID_EFRSB', $trade) ? $trade->ID_EFRSB : NULL;
            $auction->id_external = array_key_exists('ID_External', $trade) ? $trade->ID_External : NULL;
            $auction->trade_place_id = $tradePlace;
            $auction->trade_id = $invitation['@attributes']['TradeId'];
            $auction->publish_date = $invitation['@attributes']['EventTime'];
            $auction->debtor_id = $debtor_exists->id;
            $auction->arbitr_manager_id = is_null($arbitr_manager) ?: $arbitr_manager->id;
            $auction->company_trade_organizer_id = is_null($trade_organizer) ?: $trade_organizer->id;
            $auction->auction_type_id = AuctionType::where('title', $invitation[$prefix . 'TradeInfo']['@attributes']['AuctionType'])->first()->id;
            $auction->result_date = array_key_exists($prefix . 'CloseForm', $invitation[$prefix . 'TradeInfo']) ? $invitation[$prefix . 'TradeInfo'][$prefix . 'CloseForm']['@attributes']['TimeResult'] : NULL;
            $auction->event_start_date = array_key_exists($prefix . 'OpenForm', $invitation[$prefix . 'TradeInfo']) ? $invitation[$prefix . 'TradeInfo'][$prefix . 'OpenForm']['@attributes']['TimeBegin'] : NULL;
            $auction->event_end_date = array_key_exists($prefix . 'OpenForm', $invitation[$prefix . 'TradeInfo']) && array_key_exists('TimeEnd', $invitation[$prefix . 'TradeInfo'][$prefix . 'OpenForm']) ? $invitation[$prefix . 'TradeInfo'][$prefix . 'OpenForm']['TimeEnd'] : NULL;
            $auction->application_start_date = $invitation[$prefix . 'TradeInfo'][$prefix . 'Application']['@attributes']['TimeBegin'];
            $auction->application_end_date = $invitation[$prefix . 'TradeInfo'][$prefix . 'Application']['@attributes']['TimeEnd'];
            $auction->price_form = $invitation[$prefix . 'TradeInfo']['@attributes']['FormPrice'] == 'OpenForm' ? 'open' : 'close';
            if (array_key_exists($prefix . 'LegalCase', $invitation)) {
                $auction->case_number = $invitation[$prefix . 'LegalCase']['@attributes']['CaseNumber'];
                $auction->court = $invitation[$prefix . 'LegalCase']['@attributes']['CourtName'];
            }
            $auction->save();
            $url = null;
            if (array_key_exists($prefix . 'Attach', $invitation[$prefix . 'TradeInfo'])) {

                if (mb_stripos($invitation[$prefix . 'TradeInfo'][$prefix . 'Attach'][$prefix . 'FileName'], 'фото') !== false) {
                    $images = $this->uploadFile($invitation[$prefix . 'TradeInfo'], $auction, $prefix, true);
                } else {
                    $files = $this->uploadFile($invitation[$prefix . 'TradeInfo'], $auction, $prefix);
                }

            }
            foreach ($invitation[$prefix . 'TradeInfo'][$prefix . 'LotList'] as $lot) {
                if (array_key_exists('0', $lot)) {
                    foreach ($lot as $value) {
                        $this->saveLot($auction, $value, $prefix, $url);
                    }
                } else {
                    $this->saveLot($auction, $lot, $prefix, $url);
                }
            }

        } catch (\Exception $e) {
            logger('ParseTradesExc: ' . $e);
            logger($invitation);
        }

    }

    public function applicationSessionStatistic()
    {
        $content = $this->getContent('ApplicationSessionStatistic');
        $invitation = $content[0];
        $prefix = $content[1];
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction && array_key_exists($prefix . 'Attach', $invitation)) {
                $url = $this->uploadFile($invitation, $auction, $prefix);
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

    public function applicationSession($type, $id)
    {
        $content = $this->getContent($type);
        $invitation = $content[0];
        $prefix = $content[1];
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                if (array_key_exists($prefix . 'LotList', $invitation)) {
                    if (count($invitation[$prefix . 'LotList'][$prefix . 'LotInfo']) > 1) {
                        foreach ($invitation[$prefix . 'LotList'][$prefix . 'LotInfo'] as $lot) {
                            $auction_lot = $auction->lots->where('number', $lot['@attributes']['LotNumber'])->first();
                            if ($auction_lot) {
                                $auction_lot->status_id = Status::where('code', $type)->first()['id'];
                                $auction_lot->save();
                                $this->createNotification($auction_lot->id, $lot['@attributes']['EventTime'], $type, $id);
                            }
                        }
                    } else {
                        $auction_lot = $auction->lots->where('number', $invitation[$prefix . 'LotList'][$prefix . 'LotInfo']['@attributes']['LotNumber'])->first();
                        if ($auction_lot) {
                            $auction_lot->status_id = Status::where('code', $type)->first()['id'];
                            $auction_lot->save();
                            $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'], $type, $id);
                        }
                    }
                } else {
                    foreach ($auction->lots as $lot) {
                        $lot->status_id = Status::where('code', $type)->first()['id'];
                        $lot->save();
                        $this->createNotification($lot->id, $invitation['@attributes']['EventTime'], $type, $id);
                    }
                }
            }
        } catch (\Exception $e) {
            logger('parseTradeStatusExc: ' . $e);
            logger($invitation);
        }

    }

    public function biddingProcessInfo($type, $id)
    {
        $content = $this->getContent('BiddingProcessInfo');
        $invitation = $content[0];
        $prefix = $content[1];
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
                    $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'], $type, $id, $value);
                }
            }

        } catch (\Exception $e) {
            logger('biddingProcessInfo(Exc: ' . $e);
            logger($this->xml);
        }
    }

    public function annulmentMessage($type, $id)
    {
        $content = $this->getContent($type);
        $invitation = $content[0];
        $prefix = $content[1];
        logger('ANNULMENT');
        logger($invitation);
        try {

        } catch (\Exception $e) {
            logger('annulmentMessageExc: ' . $e);
            logger($invitation);
        }
    }

    public function biddingStatusWithReason($type, $id)
    {
        $content = $this->getContent($type);
        $invitation = $content[0];
        $prefix = $content[1];
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                $url = null;
                if (array_key_exists($prefix . 'Attach', $invitation)) {
                    $url = $this->uploadFile($invitation, $auction, $prefix);
                }
                if (array_key_exists($prefix . 'LotList', $invitation)) {
                    $auction_lot = $auction->lots->where('number', $invitation[$prefix . 'LotList'][$prefix . 'BiddingStateLotInfo']['@attributes']['LotNumber'])->first();
                    if ($auction_lot) {
                        $auction_lot->status_id = Status::where('code', $type)->first()['id'];
                        if (!is_null($url)) {
                            $files = $auction_lot->files;
                            $files[] = $url;
                            $auction_lot->files = $files;
                        }
                        $auction_lot->save();
                        $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'], $type, $id,
                            $invitation[$prefix . 'LotList'][$prefix . 'BiddingStateLotInfo']['@attributes']['Reason']);
                    }

                } else {
                    foreach ($auction->lots as $lot) {
                        $lot->status_id = Status::where('code', $type)->first()['id'];
                        if (!is_null($url)) {
                            $files = $lot->files;
                            $files[] = $url;
                            $lot->files = $files;
                        }
                        $lot->save();
                        $this->createNotification($lot->id, $invitation['@attributes']['EventTime'], $type, $id,
                            $invitation['@attributes']['Reason']);
                    }
                }
            }
        } catch (\Exception $e) {
            logger('biddingStatusWithReasonExc: ' . $e);
            logger($invitation);
        }
    }

    public function newTradeOrganizer($type, $id)
    {
        $content = $this->getContent($type);
        $invitation = $content[0];
        $prefix = $content[1];
        logger('NEWTRADEORG');
        logger($invitation);
        try {

        } catch (\Exception $e) {
            logger('newTradeOrganizerExc: ' . $e);
            logger($invitation);
        }
    }

    public function biddingNewTerm($type, $id)
    {
        $content = $this->getContent($type);
        $invitation = $content[0];
        $prefix = $content[1];
        logger($invitation);
        try {

        } catch (\Exception $e) {
            logger('biddingNewTermExc: ' . $e);
            logger($invitation);
        }
    }


    public function uploadFile($invitation, $auction, $prefix, $isImages = false)

    {
        logger('File');
        $filename = $invitation[$prefix . 'Attach'][$prefix . 'FileName'];
        if (strpos($filename, '.')) {
            $name_file = str_replace(' ', '-', $filename);
        } else {
            $name_file = str_replace(' ', '-', $filename . '.' . $invitation[$prefix . 'Attach'][$prefix . 'Type']);
        }

        $path = 'auction-files/auction-' . $auction->id . '/' . Carbon::now()->format('d-m-Y-H-i');
        if (!Storage::disk('public')->exists($path . '/' . $name_file)) {
            Storage::disk('public')->put($path . '/' . $name_file,
                base64_decode($invitation[$prefix . 'Attach'][$prefix . 'Blob']));
        }
        $getImages = new GenerateImagesFromFiles();
        $dest = 'app\public\auction-files\auction-' . $auction->id . '\\' . Carbon::now()->format('d-m-Y-H-i');
        $files = null;
        if ($isImages) {
            switch ($invitation[$prefix . 'Attach'][$prefix . 'Type']) {
                /*case 'pdf':
                {
                    $files = $getImages->getImagesFromPDF($name_file, $path, $dest);
                    break;
                }*/
                case ('doc' || 'docx'):
                {
                    $files = $getImages->getImagesFromDoc($name_file, $path, $dest);
                    break;
                }
                case ('zip' || 'rar'):
                {
                    $files = $getImages->getZipFiles($name_file, $path, $dest, true);
                    break;
                }
            }
            Storage::disk('public')->delete($path . '/' . $name_file);
        } else if ($invitation[$prefix . 'Attach'][$prefix . 'Type'] == 'zip' || $invitation[$prefix . 'Attach'][$prefix . 'Type'] == 'rar') {
            $files = $getImages->getZipFiles($name_file, $path, $dest);
        } else {
            $files = [Storage::disk('public')->url($path . '/' . $name_file)];
        }
        return $files;

    }

    public function createNotification($lot, $date, $type, $id, $value = null)
    {
        TradeMessage::create([
            'lot_id' => $lot,
            'value' => is_null($value) ? Status::where('code', $type)->first()['value'] : $value,
            'number' => $id,
            'date' => $date
        ]);
    }


    public function saveLot($auction, $value, $prefix, $files = null, $images = null)
    {
        if ($auction->lots->where('number', $value['@attributes']['LotNumber'])->count() == 0) {
            $new_lot = new Lot();
            $new_lot->auction_id = $auction->id;
            $new_lot->number = $value['@attributes']['LotNumber'];
            $new_lot->price = array_key_exists($prefix . 'StartPrice', $value) ? $value[$prefix . 'StartPrice'] : 0;
            if (array_key_exists($prefix . 'TradeObjectHtml', $value)) {
                $new_lot->description = $value[$prefix . 'TradeObjectHtml'];
            }
            if (array_key_exists($prefix . 'AdvancePercent', $value)) {
                $new_lot->deposit = gettype($value[$prefix . 'AdvancePercent']) == 'array' ? NULL : $value[$prefix . 'AdvancePercent'];
                $new_lot->is_deposit_rub = false;
            } elseif (array_key_exists('Advance', $value)) {
                $new_lot->deposit = gettype($value['Advance']) == 'array' ? NULL : $value['Advance'];
            }
            if (array_key_exists($prefix . 'StepPricePercent', $value)) {
                $new_lot->auction_step = gettype($value[$prefix . 'StepPricePercent']) == 'array' ? NULL : $value[$prefix . 'StepPricePercent'];
                $new_lot->is_step_rub = false;
            } elseif (array_key_exists($prefix . 'StepPrice', $value)) {
                $new_lot->auction_step = gettype($value[$prefix . 'StepPrice']) == 'array' ? NULL : $value[$prefix . 'StepPrice'];
            }
            $new_lot->status_id = Status::where('code', 'BiddingInvitation')->first()['id'];
            if (!is_null($files)) {
                $new_lot->files = $files;
            }

            if (!is_null($images)) {
                $new_lot->images = $images;
            }

            $new_lot->save();
            if (gettype($value[$prefix . 'Classification'][$prefix . 'IDClass']) == 'array') {
                foreach ($value[$prefix . 'Classification'][$prefix . 'IDClass'] as $item) {
                    $category = Category::where('code', $item)->first();
                    $new_lot->categories()->attach($category);
                }
            } else {
                $category = Category::where('code', $value[$prefix . 'Classification'][$prefix . 'IDClass'])->first();
                $new_lot->categories()->attach($category);
            }

        }
    }


}
