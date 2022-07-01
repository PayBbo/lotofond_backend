<?php

namespace App\Jobs;

use App\Models\Lot;
use App\Models\Monitoring;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MonitoringJob implements ShouldQueue
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
        $minDate = Carbon::now()->setTimezone('Europe/Moscow')->subHour();
        $maxDate = Carbon::now()->setTimezone('Europe/Moscow');
        $monitorings = Monitoring::all();
        foreach ($monitorings as $monitoring) {
            $lots = Lot::filterBy($monitoring->filters)->whereBetween('created_at', [$minDate, $maxDate])->get();
            if ($lots->count() > 0) {
                foreach ($lots as $lot) {
                    if (!$monitoring->lots->contains($lot)) {
                        $monitoring->lots()->attach($lot, ['created_at'=>$maxDate]);
                    }
                }
            }

        }
    }
}
