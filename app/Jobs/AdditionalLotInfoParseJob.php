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
       /* $imapClient = \Webklex\IMAP\Facades\Client::account('default');
        $imapClient->connect();

        $folder = $imapClient->getFolderByName('INBOX');
        try {
            $folder->messages()->unseen()->markAsRead()->chunked(function ($messages, $chunk) {
                logger($chunk);
                $messages->each(function ($message) {
                    $uid = $message->getUid();
                    logger($uid);*/
                    /* if (AdditionalLotInfo::where('uid', $uid)->exists() || !$message->hasHTMLBody()) {
                         return true;
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
                         return true;
                     }
                     $pattern = '/лоту №[0-9]*./';
                     preg_match($pattern, $htmlMail, $match);
                     if (count($match) == 0) {
                         $lot = Lot::find(1);
                         // return true;
                     } else {
                         $lot = Lot::find(1);
                         $lotNumber = preg_replace('/\D/', '', $match[0]);
                         /*  $lot = Lot::where('number', $lotNumber)
                               ->whereHas('auction', function ($query) use ($idEfrsb, $guid) {
                                   $query->when(!is_null($idEfrsb), function ($q) use ($idEfrsb) {
                                       $q->where('id_efrsb', $idEfrsb);
                                   })->when(!is_null($guid), function ($q) use ($guid) {
                                       $q->where('guid', $guid);
                                   });
                               })
                               ->first();*/
                    /*  }

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
                      $bidder = Bidder::where('email', $message->getFrom()[0]->mail)->first();
                      $additional = AdditionalLotInfo::create([
                          'uid' => $uid,
                          'message' => $html,
                          'bidder_id' => $bidder ? $bidder->id : null,
                          'lot_id' => $lot->id
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
                      }
                      foreach ($attachments as $oAttachment) {
                          $filename = str_replace(' ', '-', $oAttachment->getName());
                          $filenameExtension = File::extension($filename) ? '.' . File::extension($filename) : File::extension($filename);
                          $filename = substr(File::name($filename), 0, 15) . $filenameExtension;
                          try {
                              $oAttachment->save($full_path . $this->slash, $filename);
                          } catch (\Exception $e) {
                              logger($e);
                              logger('failed to upload file');
                              continue;
                          }
                          if ($fileService->is_image($dest, $filename) && $fileService->is_image_extension($filename)) {
                              $fileService->generatePreview($dest, $filename);
                              $preview = 'storage' . $this->slash . $dest . $this->slash . 'previews' . $this->slash . $filename;
                              $files[] = ['url' => ['main' => 'storage' . $this->slash . $dest . $this->slash . $filename, 'preview' => $preview], 'type' => 'image'];
                          } else {
                              if (mb_stripos($filename, 'фото') !== false) {
                                  /* $fileService->parseImages($dest, $filename, File::extension($filename));
                                   $hasImages = true;*/
                    /*  } else {
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
                      'lot_id' => $lot->id,
                      'additional_lot_info_id' => $additional->id
                  ]);

              }*/
          /*      });
            }, $chunk_size = 5, $start_chunk = 1);
        }catch (\Exception $e){

        }*/

    }
}
