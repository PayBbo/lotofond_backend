<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\Favourite;
use App\Models\FavouriteLot;
use App\Models\Notification;
use App\Models\PriceReduction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\MaxAttemptsExceededException;
use Illuminate\Queue\SerializesModels;

class FavouriteJob implements ShouldQueue
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
        $favourites = Favourite::whereHas('user', function ($query){
            $query->where('not_from_favourite', true);
        })->get();
        $date = Carbon::now()->setTimezone('Europe/Moscow');
        foreach ($favourites as $favourite){
            $lots = $favourite->lots->whereIn('status_id', [1,2,3,4]);
            foreach($lots as $lot){
                $eventStart = $lot->auction->event_start_date;
                $eventEnd = $lot->auction->event_end_date;
                $applicationStart = $lot->auction->application_start_date;
                $applicationEnd = $lot->auction->application_end_date;
                $resultDate = $lot->auction->result_date;
                $data = [
                    'favouriteEventStart' => $eventStart,
                    'favouriteEventEnd' => $eventEnd,
                    'favouriteApplicationStart' => $applicationStart,
                    'favouriteApplicationEnd' => $applicationEnd,
                    'favouriteResult' => $resultDate
                ];
                $offers= ['ClosePublicOffer', 'PublicOffer', "PPZ", "PPU"];
                $isPublicOffer = in_array($lot->auction->auctionType->title, $offers);
                if($isPublicOffer){
                    $changePriceDate = null;
                    $currentPriceReduction = $lot->currentPriceReduction;
                    if($currentPriceReduction){
                        $nextPrice = PriceReduction::where(['lot_id'=>$lot->id, 'start_time'=>$currentPriceReduction->end_time])->first();
                        if($nextPrice){
                            $changePriceDate = $nextPrice->start_time;
                        }
                    }
                    $data['favouritePriceReduction'] = $changePriceDate;
                }
                foreach($data as $key=>$value){
                    if(!is_null($value)) {
                        $value = Carbon::parse($value);
                        if($value > $date) {
                            $diff = Carbon::parse($value)->diffInDays($date);
                            if($diff <=7 && $favourite->user->not_settings[$key] == $diff && $favourite->user->not_settings[$key] >0) {
                                $lot_id = FavouriteLot::where(['lot_id'=>$lot->id, 'favourite_id'=>$favourite->id])->first()['id'];
                                if ($diff > 4) {
                                    $this->saveNotification($lot_id, $favourite->user_id, $key . 'InSevenDays', $diff, $lot, $value);
                                } elseif ($diff > 1) {
                                    $this->saveNotification($lot_id, $favourite->user_id, $key . 'InFourDays', $diff, $lot, $value);
                                } else {
                                    $this->saveNotification($lot_id, $favourite->user_id, $key, $value->format('d.m.y H:i'), $lot, $value);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function saveNotification($lot_id, $user_id, $message, $value, $lot, $datetime)
    {
        if(!Notification::where(['lot_id'=>$lot_id, 'user_id'=>$user_id, 'message'=>$message, 'value'=>$value])->exists()) {
            $notification = Notification::create([
                'user_id' => $user_id,
                'lot_id' => $lot_id,
                'date' => Carbon::now()->setTimezone('Europe/Moscow'),
                'type_id' => 2,
                'value' => $value,
                'message' => $message
            ]);
            $notification->notificationLots()->attach($lot);

        }
    }

}
