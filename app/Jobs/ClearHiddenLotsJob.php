<?php

namespace App\Jobs;

use App\Models\Favourite;
use App\Models\Monitoring;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\MaxAttemptsExceededException;
use Illuminate\Queue\SerializesModels;

class ClearHiddenLotsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   // public $tries = 1;

    protected $user;
    protected $lots;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $lots)
    {
        $this->lots = $lots;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $lots = $this->lots;
        foreach($lots as $lot) {
            if (!$user->hiddenLots->contains($lot)) {
                $user->hiddenLots()->attach($lot);
                $paths = Favourite::where('user_id', $user->id)->get();
                foreach ($paths as $path) {
                    if ($path->lots->contains($lot)) {
                        $path->lots()->detach($lot);
                        foreach ($path->notifications() as $notification) {
                            if ($notification->notificationLots->contains($lot)) {
                                $notification->delete();
                                $notification->notificationLots()->detach($lot);
                            }
                        }
                    }
                }
                $paths = Monitoring::where('user_id', $user->id)->get();
                foreach ($paths as $path) {
                    if ($path->lots->contains($lot)) {
                        $path->lots()->detach($lot);
                        foreach ($path->notifications as $notification) {
                            if ($notification->notificationLots->contains($lot)) {
                                if ($notification->value > 1) {
                                    $notification->value -= 1;
                                    $notification->save();
                                } else {
                                    $notification->delete();
                                }
                                $notification->notificationLots()->detach($lot);
                            }
                        }
                    }
                }
            }
        }
    }

   /* public function failed($exception)
    {
        if (
            $exception instanceof MaxAttemptsExceededException
        )
        {
            $this->delete();

            $this->dispatch($this->user, $this->lots)
                ->onConnection($this->connection)
                ->onQueue($this->queue)
                ->delay(180);

            return;
        }
    }*/
}
