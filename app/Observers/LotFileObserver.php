<?php

namespace App\Observers;

use App\Models\LotFile;
use Illuminate\Support\Facades\File;

class LotFileObserver
{
    /**
     * Handle the LotFile "created" event.
     *
     * @param  \App\Models\LotFile  $lotFile
     * @return void
     */
    public function created(LotFile $lotFile)
    {
        //
    }

    /**
     * Handle the LotFile "updated" event.
     *
     * @param  \App\Models\LotFile  $lotFile
     * @return void
     */
    public function updated(LotFile $lotFile)
    {
        //
    }

    public function deleting(LotFile $file){
        $slash = DIRECTORY_SEPARATOR;
        if ($file->type == 'file') {
            if (LotFile::where('url', stristr($file->url, 'storage'))->count() == 1) {
                $path = \storage_path('app' . $slash . 'public' . $slash . stristr($file->url, 'auction-files'));
                File::delete($path);
                $this->deleteDirectory($path);
                $this->deleteDirectory(substr_replace($path,'',strrpos($path, $slash)));
            }
        } else {
            $fileForFind = ['main'=> stristr($file->url[0], 'storage'), 'preview'=>stristr($file->url[1], 'storage')];
            if (LotFile::where('url', json_encode($fileForFind))->count() == 1) {
                $main = \storage_path('app' . $slash . 'public' . $slash . stristr($file->url[0], 'auction-files'));
                $preview = \storage_path('app' . $slash . 'public' . $slash . stristr($file->url[1], 'auction-files'));
                File::delete([$main, $preview]);
                $this->deleteDirectory($preview);
                $this->deleteDirectory($main);
                $this->deleteDirectory(substr_replace($main,'',strrpos($main, $slash)));
            }
        }
    }

    /**
     * Handle the LotFile "deleted" event.
     *
     * @param  \App\Models\LotFile  $lotFile
     * @return void
     */
    public function deleted(LotFile $lotFile)
    {
        //
    }

    /**
     * Handle the LotFile "restored" event.
     *
     * @param  \App\Models\LotFile  $lotFile
     * @return void
     */
    public function restored(LotFile $lotFile)
    {
        //
    }

    /**
     * Handle the LotFile "force deleted" event.
     *
     * @param  \App\Models\LotFile  $lotFile
     * @return void
     */
    public function forceDeleted(LotFile $lotFile)
    {
        //
    }

    private function deleteDirectory($path)
    {
        $slash = DIRECTORY_SEPARATOR;
        $pathWithoutFile = substr_replace($path,'',strrpos($path, $slash));
        if (substr($pathWithoutFile, strrpos($pathWithoutFile, $slash) + 1, strlen($pathWithoutFile)) !== 'auction-files'
            && File::isDirectory($pathWithoutFile)
            && empty(File::files($pathWithoutFile))
            && empty(File::directories($pathWithoutFile))
        ) {
            File::deleteDirectory($pathWithoutFile);
            logger('DELETE - ' .  $pathWithoutFile);
        }
    }
}
