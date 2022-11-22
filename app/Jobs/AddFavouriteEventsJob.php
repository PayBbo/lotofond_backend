<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\FavouriteLot;
use App\Models\PriceReduction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\MaxAttemptsExceededException;
use Illuminate\Queue\SerializesModels;

class AddFavouriteEventsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    protected $lots;
    protected $user;
    protected $path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lots, $user, $path)
    {
        $this->lots = $lots;
        $this->user = $user;
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lots = $this->lots;
        $user = $this->user;
        $path = $this->path;
        foreach ($lots as $lot) {
            if (!$path->lots->contains($lot) && !$user->hiddenLots->contains($lot)) {
                $path->lots()->attach($lot, ['created_at' => Carbon::now()]);
                $changePriceDate = null;
                $currentPriceReduction = $lot->currentPriceReduction;
                if($currentPriceReduction){
                    $nextPrice = PriceReduction::where(['lot_id'=>$lot->id, 'start_time'=>$currentPriceReduction->end_time])->first();
                    if($nextPrice){
                        $changePriceDate = $nextPrice->start_time;
                    }
                }
                $data = [
                    'favouriteEventStart' => $lot->auction->event_start_date,
                    'favouriteEventEnd' => $lot->auction->event_end_date,
                    'favouriteApplicationStart' => $lot->auction->application_start_date,
                    'favouriteApplicationEnd' => $lot->auction->application_end_date,
                    'favouriteResult' =>$lot->auction->result_date,
                    'favouritePriceReduction' => $changePriceDate
                ];
                foreach($data as $key=>$value) {
                    if (!is_null($value)) {
                        $lot_id = FavouriteLot::where(['lot_id'=>$lot->id, 'favourite_id'=>$path->id])->first()['id'];
                        $datetime = Carbon::parse($value);
                        if(!Event::where(['user_id'=>$user->id, 'favourite_lot_id'=>$lot_id, 'title'=>__('messages.' . $key, ['value' => $datetime])])->exists()) {
                            Event::create([
                                'user_id' => $user->id,
                                'favourite_lot_id' => $lot_id,
                                'event_type' => 'event',
                                'date' => $datetime->format('y-m-d'),
                                'time' => $datetime->format('H:i'),
                                'title' => __('messages.' . $key, ['value' => $datetime])
                            ]);
                        }
                    }
                }

            }
        }
    }

    public function failed($exception)
    {
        if (
            $exception instanceof MaxAttemptsExceededException
        )
        {
            $this->delete();

            $this->dispatch($this->lots, $this->user, $this->path)
                ->onConnection($this->connection)
                ->onQueue($this->queue)
                ->delay(180);

            return;
        }
    }
}
