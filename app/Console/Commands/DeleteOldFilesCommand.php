<?php

namespace App\Console\Commands;

use App\Models\LotFile;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteOldFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление файлов и картинок к лотам, которые добавлены более полугода назад';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        logger('DeleteOldFilesJob ' . Carbon::now()->subDays(7)->subMonths(6)->endOfMonth()->endOfDay()->format('Y-m-d H:i:s'));
        $lastDate = Carbon::now()->subDays(7)->subMonths(6);
        $path = Storage::disk('public')->path('auction-files');
        $commFirst = "find " . $path . " -type d \\( -name \"*-" .  $lastDate->format('m-Y') . "-*\" \\) -exec rm -r {} \\;";
        $this->execCommand($commFirst);
        $commSecond = "find " . $path . " -type d -empty -exec rm -r {} \;";
        $this->execCommand($commSecond);
        LotFile::where('created_at', '<=', $lastDate->endOfDay()->format('Y-m-d H:i:s'))->delete();
        logger('-----------------------------------------');
        return 0;
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
