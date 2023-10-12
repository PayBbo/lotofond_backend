<?php

namespace App\Console\Commands;

use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\SoapWrapperService;
use App\Jobs\AdditionalLotInfoParseJob;
use App\Jobs\FixLotRegionJob;
use App\Jobs\ParseTrades;

use App\Jobs\SendApplication;
use App\Models\AdditionalLotInfo;
use App\Models\Lot;
use App\Models\Region;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Console\Command;

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

        /** $startDate = Carbon::parse('2023-07-13 05:00');
         * $endDate = Carbon::parse('2023-07-13 12:30');
         * while ($startDate < $endDate) {
         * $startFrom = $startDate->format('Y-m-d\TH:i:s');
         * $startDate->addMinutes(30);
         * dispatch((new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')))->onQueue('parse'));
         * }*/

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
        $soapWrapper = new SoapWrapper();
        $service = new SoapWrapperService($soapWrapper);
        //10210474
        $xml = $service->getTradeMessageContent(15096676);
        $getTradeMessageContent = new GetTradeMessageContent($xml, 'BiddingInvitation');
        $getTradeMessageContent->switchMessageType(81, 15096676, '17916bd0-00e9-49f4-9482-508b54de7dcb');

        $xml = $service->getTradeMessageContent(15102978);
        $getTradeMessageContent = new GetTradeMessageContent($xml, 'ApplicationSessionStart');
        $getTradeMessageContent->switchMessageType(81, 15102978, '07ddb148-b0ea-4ce9-a335-a2a82f87a21d');

        $otherLotMessages = [
            ['id'=>15118489, 'guid'=>'7ab1cd64-884b-4ee0-bea8-29265f2f0c99'],
            ['id'=>15136610, 'guid'=>'b0dc029f-d4d4-41d6-9ad8-523694c33099'],
            ['id'=>15154107, 'guid'=>'629e8b51-aad6-4856-8a35-2fa2a2acba95'],
            ['id'=>15169870, 'guid'=>'4fa2f735-5424-493c-b286-783d0c7ef3b7'],
            ['id'=>15179827, 'guid'=>'020ce558-cdb9-492f-8a9a-480cfe23a903'],
            ['id'=>15196064, 'guid'=>'a60ce36b-141b-4711-8687-331214b300ff'],
            ['id'=>15202754, 'guid'=>'1a7c192c-2b9f-4f93-8911-0a3bdc50529c'],
            ['id'=>15223241, 'guid'=>'033325ce-9300-43d6-9434-87a508752d0a'],
        ];
        foreach ($otherLotMessages as $otherLotMessage){
            $xml = $service->getTradeMessageContent($otherLotMessage['id']);
            $getTradeMessageContent = new GetTradeMessageContent($xml, 'BiddingProcess');
            $getTradeMessageContent->switchMessageType(81, $otherLotMessage['id'], $otherLotMessage['guid']);
        }
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
    }

}
