<?php

namespace App\Console\Commands;


use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\ParseDataFromRosreestrService;
use App\Http\Services\Parse\SoapWrapperService;
use App\Jobs\ChangeEmail;
use App\Jobs\FavouriteJob;
use App\Jobs\MonitoringJob;
use App\Jobs\MonitoringNotificationJob;
use App\Jobs\ParseArbitrManager;
use App\Jobs\ParseDebtorMessages;
use App\Jobs\ParseTrades;
use App\Jobs\SendLotsToChannel;
use App\Models\Bidder;
use App\Models\BiddingResult;
use App\Models\Lot;
use App\Models\Notification;
use App\Models\Param;
use App\Models\PriceReduction;
use App\Models\TestMessage;
use App\Models\User;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Midnite81\Xml2Array\Xml2Array;


class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*  Cache::forget('countRealtyLotsChannel');
          Cache::forget('countTransportLotsChannel');
          dispatch(new SendLotsToChannel);*/
        //dispatch(new FavouriteJob);
        //    dispatch(new MonitoringJob);
        //  dispatch(new MonitoringNotificationJob('hourly'));
        //dispatch(new ParseDebtorMessages);
        /*   $startDate = Carbon::parse('2022-11-24 00:00');
           $endDate = Carbon::parse('2022-11-24 12:00');
           while ($startDate < $endDate) {
               $startFrom = $startDate->format('Y-m-d\TH:i:s');
               $startDate->addHours(3);
               dispatch((new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')))->onQueue('parse'));
           }*/
        // dispatch(new ParseTrades);
        //$get_trade_message_content = new GetTradeMessageContent($xml, 'BiddingInvitation');
        //$get_trade_message_content->switchMessageType(1, $xml, 13275260);
        /*  $soapWrapper = new SoapWrapper();
           $service = new SoapWrapperService($soapWrapper);
           //10210474
           $xml = $service->getTradeMessageContent( 13669916);
           logger($xml);*/
        /*      $soapWrapper = new SoapWrapper();
              $service = new SoapWrapperService($soapWrapper);
              logger(json_encode($service->getTradeMessagesByTrade( '140376', '1656057203', Carbon::parse('2022-09-06 13:00:00')->format('Y-m-d\TH:i:s'))));*/
        $value = ['PublicOffer', 'ClosePublicOffer'];
        $lots = Lot::whereHas('auction.auctionType', function ($q) use ($value) {
            $q->whereIn('title', $value);
        })->latest()->limit(1000)->get();
        foreach ($lots as $lot) {
            try {
                $bidInv = $lot->tradeMessages()->where('value', 'biddingDeclared')->first();
                $soapWrapper = new SoapWrapper();
                $service = new SoapWrapperService($soapWrapper);
                $xmlBid = $service->getTradeMessageContent($bidInv->number);
                $xmlBid = Xml2Array::create($xmlBid)->toArray();
                $type = 'BiddingInvitation';
                $key = preg_grep('/:Body/', array_keys($xmlBid));
                if (array_key_exists('ns1:Set' . $type, $xmlBid[$key[0]])) {
                    $invitation = $xmlBid[$key[0]]['ns1:Set' . $type]['ns1:' . $type];
                    $prefix = 'ns1:';
                } else {
                    $invitation = $xmlBid[$key[0]]['Set' . $type][$type];
                    $prefix = '';
                }
                $id = $invitation[$prefix . 'IDEFRSB'];
                $xml = $service->getMessageContent($id);
                $xml = Xml2Array::create($xml)->toArray();
                $test = new TestMessage();
                $test->lot_id = $lot->id;
                $test->message_id = $xml['Id'];
                if (array_key_exists('Auction', $xml['MessageInfo'])) {
                    if (strpos($xml['Publisher']['@attributes']['type'], 'ArbitrManager')) {
                        $test->arbitration_manager = $xml['Publisher'];
                        if (array_key_exists('Fio', $xml['Publisher'])) {
                            $test->arbitr_fio = $xml['Publisher']['Fio']['LastName'] . ' ' . $xml['Publisher']['Fio']['FirstName'] . ' ' . $xml['Publisher']['Fio']['MiddleName'];
                        } elseif (array_key_exists('Name', $xml['Publisher'])) {
                            $test->arbitr_name = $xml['Publisher']['Name'];
                        }
                        $test->sro = $xml['Publisher']['Sro']['Name'];
                    } else {
                        $test->organizer = $xml['Publisher'];
                        if (array_key_exists('Fio', $xml['Publisher'])) {
                            $test->organizer_fio = $xml['Publisher']['Fio']['LastName'] . ' ' . $xml['Publisher']['Fio']['FirstName'] . ' ' . $xml['Publisher']['Fio']['MiddleName'];
                        } elseif (array_key_exists('Name', $xml['Publisher'])) {
                            $test->organizer_name = $xml['Publisher']['Name'];
                        }
                    }
                    $test->trade_site = $xml['MessageInfo']['Auction']['TradeSite'];
                    $test->text = $xml['MessageInfo']['Auction']['Text'];
                    try {
                        $lots = $xml['MessageInfo']['Auction']['LotTable']['AuctionLot'];
                        if (array_key_exists('Order', $lots)) {
                            $auctionLot = $lots;
                            if ($auctionLot['Order'] != $lot->number) {
                                $test->start_price = $auctionLot['StartPrice'];
                                if (array_key_exists('Step', $auctionLot) && gettype($auctionLot['Step']) != 'array' && strlen((string)$auctionLot['Step']) > 0) {
                                    $test->auction_step = $auctionLot['Step'];
                                }
                                if (array_key_exists('Advance', $auctionLot) && gettype($auctionLot['Advance']) != 'array' && strlen((string)$auctionLot['Advance']) > 0) {
                                    $test->advance = $auctionLot['Advance'];
                                }
                                if (array_key_exists('AuctionStepUnit', $auctionLot) && gettype($auctionLot['AuctionStepUnit']) != 'array' && strlen((string)$auctionLot['AuctionStepUnit']) > 0) {
                                    $test->auction_step_unit = $auctionLot['AuctionStepUnit'];
                                }
                                if (array_key_exists('AdvanceStepUnit', $auctionLot) && gettype($auctionLot['AdvanceStepUnit']) != 'array' && strlen((string)$auctionLot['AdvanceStepUnit']) > 0) {
                                    $test->advance_step_unit = $auctionLot['AdvanceStepUnit'];
                                }
                                if (array_key_exists('PriceReduction', $auctionLot) && gettype($auctionLot['PriceReduction']) != 'array' && strlen((string)$auctionLot['PriceReduction']) > 0) {
                                    $test->price_reduction = $auctionLot['PriceReduction'];
                                }
                                $test->save();
                            }
                        } else {
                            foreach ($lots as $auctionLot) {
                                if ($auctionLot['Order'] != $lot->number) {
                                    continue;
                                }
                                $test->start_price = $auctionLot['StartPrice'];
                                if (array_key_exists('Step', $auctionLot) && gettype($auctionLot['Step']) != 'array' && strlen((string)$auctionLot['Step']) > 0) {
                                    $test->auction_step = $auctionLot['Step'];
                                }
                                if (array_key_exists('Advance', $auctionLot) && gettype($auctionLot['Advance']) != 'array' && strlen((string)$auctionLot['Advance']) > 0) {
                                    $test->advance = $auctionLot['Advance'];
                                }
                                if (array_key_exists('AuctionStepUnit', $auctionLot) && gettype($auctionLot['AuctionStepUnit']) != 'array' && strlen((string)$auctionLot['AuctionStepUnit']) > 0) {
                                    $test->auction_step_unit = $auctionLot['AuctionStepUnit'];
                                }
                                if (array_key_exists('AdvanceStepUnit', $auctionLot) && gettype($auctionLot['AdvanceStepUnit']) != 'array' && strlen((string)$auctionLot['AdvanceStepUnit']) > 0) {
                                    $test->advance_step_unit = $auctionLot['AdvanceStepUnit'];
                                }
                                if (array_key_exists('PriceReduction', $auctionLot) && gettype($auctionLot['PriceReduction']) != 'array' && strlen((string)$auctionLot['PriceReduction']) > 0) {
                                    $test->price_reduction = $auctionLot['PriceReduction'];
                                }
                                $test->save();
                            }
                        }

                    } catch (\Exception $e) {
                        logger($e);
                        logger($lots);
                        logger($xml);
                    }
                }

            } catch (\Exception $e) {
                logger($e);
                logger($lot->id);
            }
        }
        /*  $table = TestMessage::select(
              'lot_id',
              'message_id',
              'start_price',
              'auction_step',
              'auction_step_unit',
              'advance',
              'advance_step_unit',
              'price_reduction',
              'organizer_fio',
              'arbitr_fio',
              'sro',
              'text',
              'trade_site',
              'arbitration_manager',
              'organizer'
          )->get();
           $file = fopen('test_lots.csv', 'w');
           fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
           fputcsv($file, ['Номер лота у нас', 'Номер сообщения', 'Начальная цена', 'Шаг цены', 'Единицы измерения шага аукциона', 'Задаток', 'Единицы измерения задатка', 'Снижение цены',
               'ФИО Организатора','ФИО Арбитра', 'Название компании организатора','Название компании организатора', 'СРО АУ','Текст сообщения','Торговая площадка',  'Арбитр', 'Организатор'], ';');
           foreach ($table as $row) {
               fputcsv($file, $row->toArray(), ';');
           }
           fclose($file);*/

    }
}
