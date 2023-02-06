<?php

namespace App\Console\Commands;


use App\Http\Services\Parse\CookieService;
use App\Http\Services\Parse\DescriptionExtractsService;
use App\Http\Services\Parse\FilesService;
use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\ParseDataFromRosreestrService;
use App\Http\Services\Parse\PriceReductionService;
use App\Http\Services\Parse\SoapWrapperService;
use App\Http\Services\PushNotificationService;
use App\Http\Services\ReestrApiService;
use App\Http\Services\SendCodeService;
use App\Jobs\ChangeEmail;
use App\Jobs\FavouriteJob;
use App\Jobs\MakeProcessedDescription;
use App\Jobs\MonitoringJob;
use App\Jobs\MonitoringNotificationJob;
use App\Jobs\ParseArbitrManager;
use App\Jobs\ParseDebtorMessages;
use App\Jobs\ParseTrades;
use App\Jobs\SendApplication;
use App\Jobs\SendLotsToChannel;
use App\Models\Auction;
use App\Models\Bidder;
use App\Models\BiddingResult;
use App\Models\Contact;
use App\Models\EgrnStatement;
use App\Models\HolidayDate;
use App\Models\Lot;
use App\Models\LotFile;
use App\Models\LotParam;
use App\Models\Notification;
use App\Models\Param;
use App\Models\PriceReduction;
use App\Models\Region;
use App\Models\SroAu;
use App\Models\TestMessage;
use App\Models\User;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use GuzzleHttp\RequestOptions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Midnite81\Xml2Array\Xml2Array;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


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
        $auctions = Auction::whereBetween('created_at', ['2023-02-04 00:00', '2023-02-06 20:00'])->get();
        foreach ($auctions as $auction) {
            $path = 'auction-files' . DIRECTORY_SEPARATOR . 'auction-' . $auction->id;
            $this->deleteAllFilesForExtract($path, $path);
            rmdir($path);
            $auction->delete();
        }
       /* $startDate = Carbon::parse('2023-02-04 00:00');
        $endDate = Carbon::parse('2022-02-06 16:00');
        while ($startDate < $endDate) {
            $startFrom = $startDate->format('Y-m-d\TH:i:s');
            $startDate->addHours(2);
            dispatch((new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')))->onQueue('parse'));
        }*/


        /*$startDate = Carbon::parse('2023-01-27 14:00');
        $startFrom = $startDate->format('Y-m-d\TH:i:s');
        $startDate->addHour();
        dispatch((new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')))->onQueue('parse'));*/
        // dispatch(new ParseTrades);
        //$get_trade_message_content = new GetTradeMessageContent($xml, 'BiddingInvitation');
        //$get_trade_message_content->switchMessageType(1, $xml, 13275260);
        /*     $soapWrapper = new SoapWrapper();
              $service = new SoapWrapperService($soapWrapper);
              //10210474
              $xml = $service->getTradeMessageContent( 13672686);
              logger($xml);*/
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


        /*      $soapWrapper = new SoapWrapper();
              $service = new SoapWrapperService($soapWrapper);
              $xml = $service->getMessageContent(10709933);
              logger($xml);*/
        // $id = 10709933;

    }


    public function deleteAllFilesForExtract($dir, $s_path)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . $this->slash . $object) && !is_link($dir . $this->slash . $object)) {
                        $this->deleteAllFilesForExtract($dir . $this->slash . $object, $s_path);
                    } else {
                        unlink($dir . $this->slash . $object);
                    }
                }
            }
            if ($dir !== $s_path) {
                rmdir($dir);
            }
        }
    }
}
