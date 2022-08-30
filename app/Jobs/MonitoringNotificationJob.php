<?php

namespace App\Jobs;

use App\Models\Monitoring;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MonitoringNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notTime;
    protected $startDate;
    protected $endDate;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notTime)
    {
        $this->notTime = $notTime;
        $this->endDate = Carbon::now()->setTimezone('Europe/Moscow');
        switch ($notTime){
            case 'hourly':{
                $this->startDate = $this->endDate->subHour();
                break;
            }
            case 'daily':{
                $this->startDate = $this->endDate->subDay();
                break;
            }
            case 'weekly':{
                $this->startDate = $this->endDate->subWeek();
                break;
            }
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $monitorings = Monitoring::where('not_time', $this->notTime)->whereHas('user', function ($query){
            $query->where('not_from_monitoring', true);
        })->get();
        $startDate = $this->startDate;
        foreach ($monitorings as $monitoring) {
            $newLotsCount = $monitoring->lots()->wherePivot('created_at', '>', $startDate)->count();
            if($newLotsCount>0) {
                $notification = Notification::create([
                    'user_id' => $monitoring->user_id,
                    'date' => Carbon::now()->setTimezone('Europe/Moscow'),
                    'type_id' => 3,
                    'value' => $newLotsCount,
                    'monitoring_id' => $monitoring->id,
                    'message'=>'monitoring'
                ]);
                foreach( $monitoring->lots()->wherePivot('created_at', '>', $startDate)->get() as $lot){
                    $notification->notificationLots()->attach($lot);
                }
            }
        }
    }
}
