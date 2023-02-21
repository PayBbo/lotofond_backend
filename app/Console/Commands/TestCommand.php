<?php

namespace App\Console\Commands;

use App\Http\Services\Parse\FilesService;
use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\GetTradeMessages;
use App\Http\Services\Parse\SoapWrapperService;
use App\Http\Services\PushNotificationService;
use App\Http\Services\UserAgentService;
use App\Jobs\AdditionalLotInfoParseJob;
use App\Jobs\NewUsersNotificationsJob;
use App\Jobs\ParseTrades;
use App\Jobs\SendApplication;
use App\Models\AdditionalLotInfo;
use App\Models\Auction;
use App\Models\Bidder;
use App\Models\Lot;
use App\Models\LotFile;
use App\Models\Monitoring;
use App\Models\Notification;
use App\Models\TradeMessage;
use App\Models\TradePlace;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
        $startDate = Carbon::parse('2023-02-21 06:00');
        $endDate = Carbon::parse('2023-02-21 14:00');
        while ($startDate < $endDate) {
            $startFrom = $startDate->format('Y-m-d\TH:i:s');
            $startDate->addHours(2);
            dispatch((new ParseTrades($startFrom, $startDate->format('Y-m-d\TH:i:s')))->onQueue('parse'));
        }

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
       /* $imapClient = \Webklex\IMAP\Facades\Client::account('default');
        $imapClient->connect();
        logger($imapClient->authentication);

        $messages = $imapClient->getFolderByName('INBOX')->messages()->unseen()->get();

        foreach ($messages as $message) {
            $uid = $message->getUid();
            if (AdditionalLotInfo::where('uid', $uid)->exists() || !$message->hasHTMLBody()) {
                logger('not exists html');
                logger($message);
                logger('----------------');
                continue;
            }
            $html = $message->getHTMLBody(true);
            logger($html);
            $pattern = '/<blockquote[\s\S]*?<\/blockquote>/';
            preg_match_all($pattern, $html, $matches);
            if (count($matches[0]) == 0) {
                logger('not exists message');
                logger($message);
                logger('----------------');
                continue;
            }
            $mail = $matches[0][0];
            $pattern = '/<p style="display:none" class="lot-id_mr_css_attr">[0-9]*?<\/p>/';
            preg_match($pattern, $mail, $match);
            if (count($match) == 0) {
                logger($mail);
                continue;
            }
            $lotId = preg_replace('/\D/', '', $match[0]);
            logger('lotId '.$lotId);
            $lot = Lot::find(1);
            if (!$lot) {
                continue;
            }
            $html = str_replace($mail, '', $html);
            $html = str_replace('&nbsp;', '', $html);
            $pattern = '/<img[\s\S]*?>/';
            preg_match_all($pattern, $html, $matches);
            if (count($matches[0]) > 0) {
                foreach ($matches[0] as $img) {
                    $html = str_replace($img, '', $html);
                }
            }
            $pattern = '/<div data-signature-widget="container"[\s\S]*? /';
            preg_match($pattern, $html, $match);
            if (count($match) > 0) {
                $html = str_replace($match[0], '<div data-signature-widget="container" style="display:none"><div ', $html);
            }
            $html = str_replace('div', 'p', $html);
            $bidder = Bidder::where('email', $message->getFrom()[0]->mail)->first();
            $additional = AdditionalLotInfo::create([
                'uid' => $uid,
                'message' => $html,
                'bidder_id' => $bidder ? $bidder->id : null,
                'lot_id' => $lotId
            ]);
            $attachments = $message->getAttachments();
            $files = [];
            $hasImages = false;
            $fileService = new FilesService();
            $time = Carbon::now()->format('d-m-Y-H-i');
            $dest = 'auction-files' . $this->slash . 'auction-' . $lot->auction_id . $this->slash . $time;
            $dir = 'app' . $this->slash . 'public' . $this->slash . 'auction-files' . $this->slash . 'auction-' . $lot->auction_id . $this->slash . $time;
            $full_path = \storage_path($dir);
            if (!file_exists($full_path)) {
                $fileService->createTempDir($dest);
                // mkdir($full_path, 0777, true);
            }
            foreach ($attachments as $oAttachment) {
                $filename = str_replace(' ', '-', $oAttachment->getName());
                $filenameExtension = File::extension($filename) ? '.' . File::extension($filename) : File::extension($filename);
                $filename = substr(File::name($filename), 0, 200) . $filenameExtension;
                $oAttachment->save($full_path . $this->slash, $filename);
                if ($fileService->is_image($dest, $filename) && $fileService->is_image_extension($filename)) {
                    $fileService->generatePreview($dest, $filename);
                    $preview = 'storage' . $this->slash . $dest . $this->slash . 'previews' . $this->slash . $filename;
                    $files[] = ['url' => ['main' => 'storage' . $this->slash . $dest . $this->slash . $filename, 'preview' => $preview], 'type' => 'image'];
                } else {
                    if (mb_stripos($filename, 'фото') !== false) {
                        $fileService->parseImages($dest, $filename, File::extension($filename));
                        $hasImages = true;
                    } else {
                        $files[] = ['url' => 'storage' . $this->slash . $dest . $this->slash . $filename, 'type' => 'file'];
                    }
                }
            }
            if ($hasImages) {
                $images = $fileService->createPreview($dest);
                foreach ($images as $image) {
                    $files[] = ['url' => $image, 'type' => 'image'];
                }
            }
            foreach ($files as $file) {
                LotFile::create([
                    'url' => json_encode($file['url']),
                    'type' => $file['type'],
                    'lot_id' => $lotId,
                    'additional_lot_info_id' => $additional->id
                ]);

            }

            $message->setFlag('Seen');
        }*/

    }
}
