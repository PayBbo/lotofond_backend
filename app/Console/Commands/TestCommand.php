<?php

namespace App\Console\Commands;

use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\PriceFormatterService;
use App\Http\Services\Parse\SoapWrapperService;
use App\Http\Services\PushNotificationService;
use App\Jobs\AdditionalLotInfoParseJob;
use App\Jobs\DeleteOldFilesJob;
use App\Jobs\FixLotRegionJob;
use App\Jobs\MonitoringJob;
use App\Jobs\ParseTrades;

use App\Jobs\SendApplication;
use App\Models\AdditionalLotInfo;
use App\Models\Application;
use App\Models\Auction;
use App\Models\Lot;
use App\Models\LotFile;
use App\Models\Monitoring;
use App\Models\Notification;
use App\Models\Region;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

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

    protected $slash = DIRECTORY_SEPARATOR;

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

        /*$startDate = Carbon::parse('2023-10-16 13:00');
        $endDate = Carbon::parse('2023-10-24 00:00');*/
        /*$startDate = Carbon::parse('2024-02-09 14:00');
        $endDate = Carbon::parse('2024-02-17 16:45');
        while ($startDate < $endDate) {
            $startFrom = $startDate->format('Y-m-d\TH:i:s');
            $startDate->addMinutes(15);
            dispatch((new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')))->onQueue('parse'));
        }*/

        /* $lotCount = Lot::whereHas('paramsLot', function ($query) {
             return $query->where('param_id', 4);
         })->whereDoesntHave('regions', function ($query) {
             return $query->where('is_debtor_region', false);
         })->pluck('id')->toArray();
         logger(count($lotCount));*/

        /*$lotCount = Lot::whereHas('paramsLot', function ($query) {
            return $query->where('param_id', 4);
        })->whereDoesntHave('regions', function ($query) {
            return $query->where('is_debtor_region', false);
        })->pluck('id')->toArray();
        logger(count($lotCount));*/


        // dispatch(new ParseTrades);
        //$get_trade_message_content = new GetTradeMessageContent($xml, 'BiddingInvitation');
        //$get_trade_message_content->switchMessageType(1, $xml, 13275260);
        /* $soapWrapper = new SoapWrapper();
         $service = new SoapWrapperService($soapWrapper);

         $xml = $service->getTradeMessageContent(15228383);
         $getTradeMessageContent = new GetTradeMessageContent($xml, 'BiddingInvitation');
         $getTradeMessageContent->switchMessageType(5, 15228383, '36cff9e8-113e-4fc3-867d-0d566b5261cd');*/


        /*    $soapWrapper = new SoapWrapper();
                  $service = new SoapWrapperService($soapWrapper);
                  logger(json_encode($service->getTradeMessagesByTrade( '100000090', '5610149787', Carbon::parse('2022-09-06 13:00:00')->format('Y-m-d\TH:i:s'))));
        */
        /*  $table = TestMessage::select(
              'message_id',
              'start_price',
              'min_price',
              'auction_step',
              'auction_step_unit',
              'price_reduction',
              'text',
              'price_red_json',
              'period'
          )->get();
          $file = fopen('test_lots.csv', 'w');
          fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
          fputcsv($file, [ 'Номер сообщения', 'Начальная цена', 'Минимальная цена', 'Шаг цены', 'Единица измерения шага цены', 'Снижение цены', 'Текст сообщения', 'Построенный график снижения цена', 'Период (календарные/рабочие дни)'], ';');
          foreach ($table as $row) {
              fputcsv($file, $row->toArray(), ';');
          }
          fclose($file);*/

        //dispatch((new AdditionalLotInfoParseJob())->onQueue('parse'));

        /* $texts = AdditionalLotInfo::get();

         foreach ($texts as $addition) {
             $text = $addition->message;

             $text = str_replace('</p>', ' </p>', $text);
             $text = str_replace('<br>', ' ', $text);
             $text = str_replace("&nbsp;", " ", $text);
             $text = preg_replace("/<([^>]*(<|$))/", "&lt;$1 ", $text);
             $text = strip_tags($text);
             $text = str_replace(chr(194), " ", $text);
             $text = str_replace(chr(160), " ", $text);
             $text = preg_replace(array('/\s{2,}/', '/[\r\t\n]/', '/\r/', '/\t/', '/\n/'), ' ', $text);
             $text = str_replace("&lt;", "", str_replace("&gt;", "", $text));
             $text = iconv('utf-8//IGNORE', 'windows-1251//IGNORE', $text);
             $text = iconv('windows-1251//IGNORE', 'utf-8//IGNORE', $text);
             $addition->message = $text;
             $addition->save();

         }*/
        /* $startDate = Carbon::parse('2023-10-16 13:00');
           $endDate = Carbon::parse('2023-10-24 23:00');
        while ($startDate < $endDate) {
     $startFrom = $startDate->format('Y-m-d\TH:i:s');
     $startDate->addMinutes(15);
     dispatch((new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')))->onQueue('parse'));
 }*/

        /* $lastDate = '2023-04-25 00:00:00';
         $files = LotFile::where('created_at', '<=', $lastDate)->count();
         logger($files);*/

        /*$pushService = new PushNotificationService("test", "test", 43, "platform");
        $pushService->sendPushNotification();*/

    }

}
