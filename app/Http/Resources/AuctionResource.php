<?php

namespace App\Http\Resources;

use App\Models\Favourite;
use App\Models\Monitoring;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = User::find(auth()->id());
        $countDays = null;
        if(!is_null($this->auction->result_date)){
            $start = Carbon::parse(Carbon::now())->setTimezone('Europe/Moscow');
            $end =  Carbon::parse($this->auction->result_date)->setTimezone('Europe/Moscow');
            $countDays = $end->diffInDays($start);
        }
        $categories = [];
        $parents = [];
        foreach ($this->categories as $category){
            $categories[] = $category->title;
            if(!is_null($category->parent())) {
                $parents[] = $category->parent()->title;
            }
        }
        return [
            'auctionId'=>$this->auction_id,
            'lotId'=>$this->id,
            'isWatched' => auth()->check() ? $user->seenLots->contains($this->id) : false,
            'categories'=>['cats'=>array_unique($categories), 'mainCats'=>array_unique($parents)],

            'isPinned'=>  auth()->check() ?  $user->fixedLots->contains($this->id) : false,
            'inFavourite' =>  auth()->check() ? Favourite::where(['user_id'=> $user->id, 'lot_id'=>$this->id])->exists() : false,
            'isHide'=> auth()->check() ? $user->hiddenLots->contains($this->id) : false,
            'label'=> $this->shortDescription(),
            'date' =>$this->auction->publish_date->format('d.m.Y H:i'),
            'state'=>$this->status->title,
            'tradingNumber'=>$this->auction->trade_id,
            'lotNumber'=>$this->number,
            'photos'=>is_null($this->images) ? [] : $this->images,
            'geoPosition'=>$this->auction->debtor->address,
            'numberOfLots'=>$this->auction->lots->count(),
            'price'=>$this->price,
            'priceState'=>$this->price_state,
            'tags'=>[],
            'inMonitoring'=>  auth()->check() ? Monitoring::where(['user_id'=> $user->id, 'lot_id'=>$this->id])->exists() : false,
            'auctionStep' =>$this->auction_step,
            'isAuctionStepRub'=>is_null($this->is_step_rub),
            'deposit'=>$this->deposit,
            'isDepositRub'=>$this->is_deposit_rub,
            'beforeEnd'=>$countDays,
            'beforeEndType'=>'days'
        ];
    }
}
