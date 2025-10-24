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

class DeleteFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dateFrom;
    protected $dateTo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dateFrom = null, $dateTo = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $slash = DIRECTORY_SEPARATOR;

        $dateFrom = $this->dateFrom ?: Carbon::now()->setTimezone('Europe/Moscow')->subDays(7)->subMonths(3)->startOfDay()->format('Y-m-d H:i:s');
        $dateTo = $this->dateFrom ?: Carbon::now()->setTimezone('Europe/Moscow')->subDays(7)->subMonths(3)->endOfDay()->format('Y-m-d H:i:s');

        logger('START DeleteFilesJob '.$dateTo);

        // собираем лоты, по которым у нас законились торги, а через 3 месяца удалялись прикрепленные файлы к лоту
        $files = \App\Models\LotFile::select([
            'lot_files.id',
            'lot_files.url',
            'lot_files.type',
            'lot_files.lot_id',
        ])
            ->whereIn('trade_messages.param', [5, 6, 7, 8])
            ->where('trade_messages.param_type', 'status_id')
            ->where('trade_messages.created_at', '>=', $dateFrom) //ограничиваем полгодом
            ->where('trade_messages.created_at', '<=', $dateTo) // дата создания раньше нынешних трех месяцев
            ->leftJoin('trade_messages', 'trade_messages.lot_id', '=', 'lot_files.lot_id')
            ->groupBy('lot_files.id')
            ->get();

        $error = 'no error';
        foreach ($files as $file) {
            try {
                if ($file->type == 'file') {
                    $path = \storage_path('app' . $slash . 'public' . $slash . stristr($file->url, 'auction-files'));
                    File::delete($path);
                    $this->deleteDirectory($path);
                    $this->deleteDirectory(substr_replace($path, '', strrpos($path, $slash)));
                } else {
                    $main = \storage_path('app' . $slash . 'public' . $slash . stristr($file->url[0], 'auction-files'));
                    $preview = \storage_path('app' . $slash . 'public' . $slash . stristr($file->url[1], 'auction-files'));
                    File::delete([$main, $preview]);
                    $this->deleteDirectory($preview);
                    $this->deleteDirectory($main);
                    $this->deleteDirectory(substr_replace($main, '', strrpos($main, $slash)));
                }
            }
            catch (\Exception $e) {
                $error = 'was error';
            }
        }

        logger('END DeleteFilesJob '.$error);
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
