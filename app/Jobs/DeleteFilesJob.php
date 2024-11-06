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
use Illuminate\Support\Facades\DB;

class DeleteFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        logger('START DeleteFilesJob');
        $dateFrom = Carbon::now()->setTimezone('Europe/Moscow')->subDays(7)->subMonths(6)->startOfDay()->format('Y-m-d');
        $dateTo = Carbon::now()->setTimezone('Europe/Moscow')->subDays(7)->subMonths(3)->endOfDay()->format('Y-m-d');
        logger('DeleteFilesJob dateFrom ' . $dateFrom);
        logger('DeleteFilesJob dateTo ' . $dateTo);
        // собираем лоты, по которым у нас законились торги, а через 3 месяца удалялись прикрепленные файлы к лоту
        $lotIds = DB::table('trade_messages')->whereIn('param', [5, 6, 7, 8])
            ->where('param_type', 'status_id')
            ->where('trade_messages.created_at', '>=', $dateFrom) //ограничиваем полгодом
            ->where('trade_messages.created_at', '<=', $dateTo) // дата создания раньше нынешних трех месяцев
            ->leftJoin('lot_files', 'trade_messages.lot_id', '=', 'lot_files.lot_id')
            ->groupBy('trade_messages.id')
            ->havingRaw('count(lot_files.id) >= 1')
            ->pluck("trade_messages.lot_id")->toArray();
        //пишем each чтобы сработал observer
        LotFile::whereIn('lot_id', $lotIds)->get()->each->delete();
        logger('END DeleteFilesJob');
    }
}
