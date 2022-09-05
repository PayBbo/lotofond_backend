<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Http\Services\Parse\BidderService;
use App\Http\Services\Parse\FilesService;
use App\Http\Services\Parse\SoapWrapperService;
use App\Http\Services\Parse\TradeService;
use App\Models\Auction;
use App\Models\AuctionType;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;

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
                if (array_key_exists($prefix . 'DebtorPerson', $debtor_data)) {
                    $debtor = get_object_vars($debtor_data['DebtorPerson']);
                } elseif (array_key_exists('DebtorCompany', $debtor_data)) {
                    $debtor = get_object_vars($debtor_data['DebtorCompany']);
                }
                $bidderParse = new BidderService('debtor', $debtor['INN'], $debtor_type);
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
            $auction->id_efrsb = array_key_exists('ID_EFRSB', $trade) ? $trade->ID_EFRSB : NULL;
            $auction->id_external = array_key_exists('ID_External', $trade) ? $trade->ID_External : NULL;
            $auction->guid = array_key_exists('GUID', $trade) ? $trade->GUID : NULL;
            $auction->trade_place_id = $tradePlace;
            $auction->trade_id = $invitation['@attributes']['TradeId'];
            $auction->publish_date =Carbon::parse($invitation['@attributes']['EventTime'])->setTimezone('Europe/Moscow');
            $auction->debtor_id = $debtor->id;
            $auction->arbitr_manager_id = is_null($arbitr_manager) ?: $arbitr_manager->id;
            $auction->company_trade_organizer_id = is_null($trade_organizer) ?: $trade_organizer->id;
            $auction->auction_type_id = AuctionType::where('title', $data['@attributes']['AuctionType'])->first()->id;
            $auction->result_date = array_key_exists($prefix . 'CloseForm', $data) ? Carbon::parse($data[$prefix . 'CloseForm']['@attributes']['TimeResult'])->setTimezone('Europe/Moscow') : NULL;
            $auction->event_start_date = array_key_exists($prefix . 'OpenForm', $data) ? Carbon::parse($data[$prefix . 'OpenForm']['@attributes']['TimeBegin'])->setTimezone('Europe/Moscow') : NULL;
            $auction->event_end_date = array_key_exists($prefix . 'OpenForm', $data) && array_key_exists('TimeEnd', $data[$prefix . 'OpenForm']) ? $data[$prefix . 'OpenForm']['TimeEnd'] : NULL;
            $auction->application_start_date = Carbon::parse($data[$prefix . 'Application']['@attributes']['TimeBegin'])->setTimezone('Europe/Moscow');
            $auction->application_end_date = Carbon::parse($data[$prefix . 'Application']['@attributes']['TimeEnd'])->setTimezone('Europe/Moscow');
            $auction->application_rules = $data[$prefix . 'Application'][$prefix.'Rules'];
            $auction->date_publish_smi = array_key_exists($prefix . 'DatePublishSMI', $data) ? Carbon::parse($data[$prefix . 'DatePublishSMI'])->setTimezone('Europe/Moscow') : NULL;
            $auction->date_publish_efir = array_key_exists($prefix . 'DatePublishEFIR', $data) ? Carbon::parse($data[$prefix . 'DatePublishEFIR'])->setTimezone('Europe/Moscow') : NULL;
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

        } catch (\Exception $e) {
            logger('ParseTradesExc: ' . $e);
            logger($invitation);
        }

    }


}
