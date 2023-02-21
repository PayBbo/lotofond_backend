<?php

namespace App\Jobs;

use App\Http\Services\Parse\FilesService;
use App\Models\AdditionalLotInfo;
use App\Models\Bidder;
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
        }
    }
}
