<?php

namespace App\Http\Resources;

use App\Models\Favourite;
use App\Models\Monitoring;
use App\Models\User;
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
        return [
            'auctionId'=>$this->auction_id,
            'lotId'=>$this->id,
            'isWatched' => $user->seenLots->contains($this->id),
            'сategory'=>$this->categories->first()->code,
            'isPinned'=> $user->fixedLots->contains($this->id),
            'inFavourite' => Favourite::where(['user_id'=> $user->id, 'lot_id'=>$this->id])->exists(),
            'isHide'=>$user->hiddenLots->contains($this->id),
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
            'inMonitoring'=>Monitoring::where(['user_id'=> $user->id, 'lot_id'=>$this->id])->exists()
        ];
    }
}
