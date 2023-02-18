<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class DeleteFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $url)
    {
        $this->type = $type;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $slash = DIRECTORY_SEPARATOR;
        if($this->type == 'file'){
            $path = \storage_path('app'.$slash.'public'.$slash.stristr($this->url, 'auction-files'));
            File::delete($path);
        }else{
            $main = \storage_path('app'.$slash.'public'.$slash.stristr($this->url[0], 'auction-files'));
            $preview = \storage_path('app'.$slash.'public'.$slash.stristr($this->url[1], 'auction-files'));
            File::delete([$main, $preview]);
        }
    }
}
