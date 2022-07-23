<?php

namespace App\Jobs;

use App\Models\Lot;
use App\Models\Monitoring;
use App\Models\Notification;
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
        $minDate = Carbon::now()->setTimezone('Europe/Moscow')->subWeek();
        $maxDate = Carbon::now()->setTimezone('Europe/Moscow');
        $monitorings = Monitoring::whereHas('user', function ($query){
            $query->where('not_from_monitoring', true);
        })->get();
        foreach ($monitorings as $monitoring) {
            $newLotsCount = 0;
            $lots = Lot::filterBy($monitoring->filters)->whereBetween('created_at', [$minDate, $maxDate])->get();
            if ($lots->count() > 0) {
                foreach ($lots as $lot) {
                    if (!$monitoring->lots->contains($lot)) {
                        $monitoring->lots()->attach($lot, ['created_at' => $maxDate]);
                        $newLotsCount+=1;
                    }
                }
            }
            if($newLotsCount>0) {
                Notification::create([
                    'user_id' => $monitoring->user_id,
                    'date' => $maxDate,
                    'type_id' => 3,
                    'value' => $newLotsCount,
                    'monitoring_id' => $monitoring->id
                ]);
            }
        }
    }
}
