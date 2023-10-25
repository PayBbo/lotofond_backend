<?php

namespace App\Jobs;

use App\Models\LotFile;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class DeleteOldFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$lastDate = Carbon::now()->subMonths(6);
        //logger('DeleteOldFilesJob ' . $lastDate->format('Y-m-d H:i:s'));
        $lastDate = '2023-04-25 00:00:00';
        $files = LotFile::where('created_at', '<=', $lastDate)->limit(300)->get();
        foreach ($files as $file) {
            $slash = DIRECTORY_SEPARATOR;
            if ($file->type == 'file') {
                logger('DELETE FILE '.$file->url);
                $path = \storage_path('app' . $slash . 'public' . $slash . stristr($file->url, 'auction-files'));
                File::delete($path);
                $this->deleteDirectory($path);
                $this->deleteDirectory(substr_replace($path, '', strrpos($path, $slash)));
                LotFile::where('url', json_encode(stristr($file->url, 'storage')))->delete();

            } else {
                $fileForFind = ['main' => stristr($file->url[0], 'storage'), 'preview' => stristr($file->url[1], 'storage')];
                logger('DELETE IMAGE ' . $file->url[0]);
                $main = \storage_path('app' . $slash . 'public' . $slash . stristr($file->url[0], 'auction-files'));
                $preview = \storage_path('app' . $slash . 'public' . $slash . stristr($file->url[1], 'auction-files'));
                File::delete([$main, $preview]);
                $this->deleteDirectory($preview);
                $this->deleteDirectory($main);
                $this->deleteDirectory(substr_replace($main, '', strrpos($main, $slash)));
                LotFile::where('url', json_encode($fileForFind))->delete();
            }
            $file->delete();
        }
    }

    private function deleteDirectory($path)
    {
        $slash = DIRECTORY_SEPARATOR;
        $pathWithoutFile = substr_replace($path, '', strrpos($path, $slash));
        if (substr($pathWithoutFile, strrpos($pathWithoutFile, $slash) + 1, strlen($pathWithoutFile)) !== 'auction-files'
            && File::isDirectory($pathWithoutFile)
            && empty(File::files($pathWithoutFile))
            && empty(File::directories($pathWithoutFile))
        ) {
            File::deleteDirectory($pathWithoutFile);
            logger('DELETE PATH '.$pathWithoutFile);
        }
    }
}
