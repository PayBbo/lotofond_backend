<?php

namespace App\Jobs;

use App\Http\Services\CacheService;
use App\Http\Services\Parse\FilesService;
use App\Models\AdditionalLotInfo;
use App\Models\Auction;
use App\Models\Lot;
use App\Models\LotFile;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdditionalLotInfoParseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $slash = DIRECTORY_SEPARATOR;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $imapClient = \Webklex\IMAP\Facades\Client::account('default');
        $imapClient->connect();

        $folder = $imapClient->getFolderByName('INBOX');
        $count = $folder->messages()->unseen()->count();
        if ($count > 30) {
            dispatch((new AdditionalLotInfoParseJob())->onQueue('parse'));
        }
        $limit = 30;
        while ($limit > 0) {
            $messages = $folder->messages()->unseen()->markAsRead()->limit(10, 1)->get();
            foreach ($messages as $message) {
                $uid = $message->getUid();
                if (!$message->hasHTMLBody()) {
                    continue;
                }
                $html = $message->getHTMLBody(true);
                $pattern = '/<blockquote[\s\S]*?<\/blockquote>/';
                preg_match_all($pattern, $html, $matches);
                $idEfrsb = null;
                $guid = null;
                $htmlMail = null;
                foreach ($matches[0] as $mail) {
                    $pattern = '/ЕФРСБ: [0-9]*<\/p>/';
                    preg_match($pattern, $mail, $match);
                    if (count($match) > 0) {
                        $idEfrsb = preg_replace('/\D/', '', $match[0]);
                    } else {
                        $pattern = '/"https:\/\/fedresurs.ru\/bidding\/[\s\S]*?"/';
                        preg_match($pattern, $mail, $match);
                        if (count($match) > 0) {
                            $href = strrchr($match[0], '/');
                            $guid = substr($href, 1, strlen($href) - 2);
                        }
                    }
                    if (!is_null($idEfrsb) || !is_null($guid)) {
                        $htmlMail = $mail;
                        break;
                    }
                }
                if (is_null($idEfrsb) && is_null($guid)) {
                    continue;
                }
                // для парсинга письма для конкретного лота
                /* $pattern = '/лоту №[0-9]*./';
                 preg_match($pattern, $htmlMail, $match);
                 if (count($match) == 0) {
                     continue;
                 } else {
                     $lotNumber = preg_replace('/\D/', '', $match[0]);
                     $lot = Lot::where('number', $lotNumber)
                         ->whereHas('auction', function ($query) use ($idEfrsb, $guid) {
                             $query->when(!is_null($idEfrsb), function ($q) use ($idEfrsb) {
                                 $q->where('id_efrsb', $idEfrsb);
                             })->when(!is_null($guid), function ($q) use ($guid) {
                                 $q->where('guid', $guid);
                             });
                         })
                         ->first();
                 }*/


                $auction = Auction::when(!is_null($idEfrsb), function ($q) use ($idEfrsb) {
                    $q->where('id_efrsb', $idEfrsb);
                })->when(!is_null($guid), function ($q) use ($guid) {
                    $q->where('guid', $guid);
                })->first();
                if (!$auction) {
                    continue;
                }

                if (AdditionalLotInfo::where('uid', $uid)->whereIn('lot_id', $auction->lots->pluck('id'))->exists()) {
                    continue;
                }

                $html = str_replace($htmlMail, '', $html);
                $html = str_replace('&nbsp;', '', $html);
                $pattern = '/<img[\s\S]*?>/';
                preg_match_all($pattern, $html, $matches);
                if (count($matches[0]) > 0) {
                    foreach ($matches[0] as $img) {
                        $html = str_replace($img, '', $html);
                    }
                }
                $html = str_replace('div', 'p', $html);
                /*START Удаление всех html-тегов и искаженных символов*/
                $text = str_replace('</p>', ' </p>', $html);
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
                /*END Удаление всех html-тегов и искаженных символов*/
                /*START Удаление почты арбитражного управляющего*/
                $arbitrEmail = $auction->arbitrationManager->email;
                $text = preg_replace('/\b' . $arbitrEmail . '\b/u', str_repeat('░', strlen($arbitrEmail) - 1), $text);
                /*END Удаление почты арбитражного управляющего*/
                $attachments = $message->getAttachments();
                $files = [];
                $hasImages = false;
                $fileService = new FilesService();
                $time = Carbon::now()->format('d-m-Y-H-i');
                $dest = 'auction-files' . $this->slash . 'auction-' . $auction->id . $this->slash . $time;
                //$dest = 'auction-files' . $this->slash . 'auction-' . $lot->auction->id . $this->slash . $time;
                $dir = 'app' . $this->slash . 'public' . $this->slash . 'auction-files' . $this->slash . 'auction-' . $auction->id . $this->slash . $time;
                //$dir = 'app' . $this->slash . 'public' . $this->slash . 'auction-files' . $this->slash . 'auction-' . $lot->auction->id . $this->slash . $time;
                $full_path = \storage_path($dir);
                if (!file_exists($full_path)) {
                    $fileService->createTempDir($dest);
                }
                foreach ($attachments as $oAttachment) {
                    $filename = $oAttachment->getName();
                    $filenameExtension = File::extension($filename) ? '.' . File::extension($filename) : File::extension($filename);
                    $filename = substr(Str::slug(File::name($filename)), 0, 150) . $filenameExtension;
                    try {
                        $oAttachment->save($full_path . $this->slash, $filename);
                    } catch (\Exception $e) {
                        continue;
                    }
                    if ($fileService->is_image($dest, $filename) && $fileService->is_image_extension($filename)) {
                        $fileService->generatePreview($dest, $filename);
                        $fileService->generateWatermark($dest . $this->slash . $filename);
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
                foreach ($auction->lots as $lot) {
                    $additional = AdditionalLotInfo::create([
                        'uid' => $uid,
                        'message' => $text,
                        'lot_id' => $lot->id
                    ]);
                    foreach ($files as $file) {
                        LotFile::create([
                            'url' => json_encode($file['url']),
                            'type' => $file['type'],
                            'lot_id' => $lot->id,
                            'additional_lot_info_id' => $additional->id
                        ]);
                    }
                }
                /*START Ответ арбитражному управлющему*/
                $replyHtml = "<p>Благодарим за ответ.</p>
<p>Если Вы считаете, что информация о лоте размещена некорректна, просим обратиться к нашему администратору по электронной почте: lotofond@yandex.ru</p>
<p> С уважением,</p>
<p>ООО «Русвопрос»</p>";
                $cacheService = new CacheService();
                $delay = $cacheService->calculateMailDelay();
                if (!is_null($delay)) {
                    dispatch((new SendApplication($replyHtml, "Благодарим за ответ", $arbitrEmail, true))->onQueue('credentials')->delay($delay));
                }
                /*END Ответ арбитражному управлющему*/
                /*$additional = AdditionalLotInfo::create([
                    'uid' => $uid,
                    'message' => $html,
                    'lot_id' => $lot->id
                ]);
                foreach ($files as $file) {
                    LotFile::create([
                        'url' => json_encode($file['url']),
                        'type' => $file['type'],
                        'lot_id' => $lot->id,
                        'additional_lot_info_id' => $additional->id
                    ]);
                }*/
            }
            $limit -= 10;
        }
    }
}
