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
        $lastDate = Carbon::now()->subMonths(6);
        logger('DeleteOldFilesJob '.$lastDate->format('Y-m-d H:i:s'));
        $files = LotFile::where('created_at', '<=', $lastDate)->limit(1000)->get();
        foreach ($files as $file){
           $file->delete();
        }
        $count = LotFile::where('created_at', '<=', $lastDate)->count();
        logger($count);
        if($count > 0)
            dispatch((new DeleteOldFilesJob)->onQueue('parse'));
    }
}
