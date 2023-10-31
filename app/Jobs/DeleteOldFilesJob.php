<?php

namespace App\Jobs;

use App\Models\LotFile;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

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
        logger('DeleteOldFilesJob ' . Carbon::now()->subDays(7)->subMonths(6)->endOfMonth()->endOfDay()->format('Y-m-d H:i:s'));
        $lastDate = Carbon::now()->subDays(7)->subMonths(6);
        $path = Storage::disk('public')->path('auction-files');
        $commFirst = "find " . $path . " -type d \\( -name \"*-" .  $lastDate->format('m-Y') . "-*\" \\) -exec rm -r {} \\";
        logger($commFirst);
        $this->execCommand($commFirst);
        $commSecond = "find " . $path . " -type d -empty -exec rm -r {} \;";
        logger($commSecond);
        $this->execCommand($commSecond);
        LotFile::where('created_at', '<=', $lastDate->endOfMonth()->endOfDay()->format('Y-m-d H:i:s'))->delete();
        logger('-----------------------------------------');
    }

    private function execCommand($comm = null)
    {
        if (!is_null($comm)) {
            try {
                logger($comm);
                exec(`$comm`);
            } catch (\Exception $exception) {
                logger($exception);
            }
        }
    }
}
