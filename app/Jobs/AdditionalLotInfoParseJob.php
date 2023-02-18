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

        $messages = $imapClient->getFolderByName('INBOX')->messages()->unseen()->get();

        foreach ($messages as $message) {
            $uid = $message->getUid();
            if(AdditionalLotInfo::where('uid', $uid)->exists()){
                continue;
            }
            if(!$message->hasHTMLBody()){
                continue;
            }
            $html = $message->getHTMLBody(true);
            $pattern = '/<blockquote[\s\S]*?<\/blockquote>/';
            preg_match_all($pattern, $html, $matches);
            if(count($matches[0]) >0){
                $mail = $matches[0][0];
                $pattern = '/<p style="display:none" class="lot-id_mr_css_attr">[0-9]*?<\/p>/';
                preg_match($pattern, $mail, $match);
                if(count($match)>0){
                    $lotId = preg_replace('/\D/', '', $match[0]);
                    logger($lotId);
                    $lot = Lot::find($lotId);
                    if(!$lot){
                        continue;
                    }
                    $html = str_replace($mail, '', $html);
                    $html = str_replace('&nbsp;', '', $html);
                    $pattern = '/<img[\s\S]*?>/';
                    preg_match_all($pattern, $html, $matches);
                    if(count($matches[0]) >0){
                        foreach ($matches[0] as $img){
                            $html =  str_replace($img, '', $html);
                        }
                    }
                    $pattern = '/<div data-signature-widget="container"[\s\S]*? /';
                    preg_match($pattern, $html, $match);
                    if(count($match)>0){
                        $html = str_replace($match[0], '<div data-signature-widget="container" style="display:none"><div ', $html);
                    }
                    $html =  str_replace('div', 'p', $html);
                    $bidder = Bidder::where('email',$message->getFrom()[0]->mail)->first();
                    logger($html);
                    logger($bidder->id);
                    $additional = AdditionalLotInfo::create([
                        'uid'=>$uid,
                        'message'=>$html,
                        'bidder_id'=> $bidder->id,
                        'lot_id'=>$lotId
                    ]);
                    logger($additional->id);
                    $attachments = $message->getAttachments();
                    foreach ($attachments as $oAttachment){
                        $time = Carbon::now()->format('d-m-Y-H-i');
                        $dest = 'auction-files'.$this->slash.'auction-' . $lot->auction_id . $this->slash . $time;
                        $dir = 'app'.$this->slash.'public'.$this->slash.'auction-files'.$this->slash.'auction-' . $lot->auction_id . $this->slash . $time;
                        $full_path = \storage_path($dir);
                        if (!file_exists($full_path)) {
                            mkdir($full_path, 0777, true);
                        }
                        $file = null;
                        $isImage = false;
                        $filename = str_replace(' ', '-', $oAttachment->getName());
                        $oAttachment->save($full_path . $this->slash, $filename);
                        if($oAttachment->getExtension() == 'jpg' || $oAttachment->getExtension() == 'png' || $oAttachment->getExtension() == 'jpeg' || $oAttachment->getExtension() == 'bmp') {
                            $fileService = new FilesService();
                            $fileService->generatePreview(Storage::get($dest.$this->slash. $filename),
                                $dest .$this->slash. 'previews' .$this->slash. $filename);
                            $preview = 'storage'.$this->slash.$dest.$this->slash.'previews'.$this->slash.$filename;
                            $file = ['main' => 'storage'.$this->slash. $dest .$this->slash. $filename, 'preview' => $preview];
                            $isImage = true;
                        }else{
                            $file =  'storage'.$this->slash. $dest . $this->slash . $filename;
                        }
                        LotFile::create([
                            'url' => json_encode($file),
                            'type' => $isImage ?  'image' : 'file',
                            'lot_id' => $lotId,
                            'additional_lot_info_id'=>$additional->id
                        ]);

                    }
                }
            }

            $message->setFlag('Seen');
        }
    }
}
