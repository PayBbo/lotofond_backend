<?php

namespace App\Jobs;

use App\Http\Services\CacheService;
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
use Illuminate\Support\Facades\Cache;

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
            $this->startFrom = Carbon::parse($startFrom);
            $this->endTo = Carbon::parse($endTo);
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
        logger('START MONITORING:' . $this->startFrom);
        $minDate = $this->startFrom;
        $maxDate = $this->endTo;
        if(!Cache::has('trialPeriod')){
            $cacheService = new CacheService();
            $cacheService->cacheTrialPeriod();
        }
        $monitorings = Monitoring::whereHas('user', function ($query){
            $query->hasByNonDependentSubquery('tariff')
            ->orWhere('email_verified_at', '>=', Carbon::now()->setTimezone('Europe/Moscow')->subDays( Cache::get('trialPeriod')));
        })->get();
        foreach ($monitorings as $monitoring) {
            $lots = Lot::whereNotIn('lots.id', $monitoring->user->hiddenLots->pluck('id'))->filterBy($monitoring->filters)
                ->whereBetween('lots.created_at', [$minDate, $maxDate])->get();
            if ($lots->count() > 0) {
                foreach ($lots as $lot) {
                    if (!$monitoring->lots->contains($lot)) {
                        $monitoring->lots()->attach($lot, ['created_at' => $maxDate]);
                    }
                }
            }
        }
        logger('END MONITORING:' . $this->endTo);
    }

}
