<?php

namespace App\Jobs;

use App\Models\Lot;
use App\Models\Monitoring;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\MaxAttemptsExceededException;
use Illuminate\Queue\SerializesModels;

class MonitoringJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $startFrom;
    protected $endTo;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($startFrom=null, $endTo=null)
    {
        if(!is_null($startFrom) && !is_null($endTo)) {
            $this->startFrom = $startFrom;
            $this->endTo = $endTo;
        }else{
            $this->startFrom = Carbon::now()->setTimezone('Europe/Moscow')->subHour();
            $this->endTo = Carbon::now()->setTimezone('Europe/Moscow');
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $minDate = $this->startFrom;
        $maxDate = $this->endTo;
        $monitorings = Monitoring::all();
        foreach ($monitorings as $monitoring) {
          //  $user = User::find($monitoring->user_id);
            $lots = Lot::whereNotIn('lots.id', $monitoring->user->hiddenLots->pluck('id'))->filterBy($monitoring->filters)
                ->whereBetween('lots.created_at', [$minDate, $maxDate])->groupBy('lots.id')->get();
            if ($lots->count() > 0) {
                foreach ($lots as $lot) {
                    if (!$monitoring->lots->contains($lot)) {
                        $monitoring->lots()->attach($lot, ['created_at' => $maxDate]);
                    }
                }
            }
        }
    }

}
