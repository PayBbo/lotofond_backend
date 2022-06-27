<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Favourite;
use App\Models\Monitoring;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class LotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = User::find(auth()->id());
        $categories = [];
        $parents = [];
        foreach ($this->categories as $category) {
            if (!is_null($category->parent())) {
                $parents[] = $category->parent();
            } else {
                $parents[] = $category;
            }
        }
        $categoriesIds = $this->categories->pluck('id')->toArray();
        foreach (array_unique($parents) as $category) {
            $subs = array_intersect($category->subcategories()->pluck('id')->toArray(), $categoriesIds);
            $categories[$category->title] = array_unique(Category::whereIn('id', $subs)->get()->pluck('title')->toArray());
        }
        $this->auction->isLotInfo = $this->isLotInfo;
        $priceReduction = null;
        if(gettype($this->price_reduction) == 'array'){
            if(count($this->price_reduction) == 0){
                $priceReduction = null;
            }else{
                $priceReduction = $this->price_reduction;
            }
        }
        return [
            'id' => $this->id,
            'trade' => new TradeResource($this->auction),
            'lotNumber' => $this->number,
            'photos' => is_null($this->images) ? [] : $this->images,
            'categories' => $categories,
            'description' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->description)),
            'state' => $this->status->code,
            'location' => $this->auction->debtor->address,
            'isWatched' => auth()->check() ? $user->seenLots->contains($this->id) : false,
            'isPinned' => auth()->check() ? $user->fixedLots->contains($this->id) : false,
            'inFavourites' => auth()->check() ? Favourite::where(['user_id' => $user->id, 'lot_id' => $this->id])->exists() : false,
            'isHide' => auth()->check() ? $user->hiddenLots->contains($this->id) : false,
            'inMonitoring' => auth()->check() ? Monitoring::where(['user_id' => $user->id, 'lot_id' => $this->id])->exists() : false,
            'startPrice' =>  $this->start_price,
            $this->mergeWhen(!is_null($this->auction_step), [
                'stepPrice' => [
                    'type' => $this->is_step_rub ? 'rubles' : 'percent',
                    'value' => $this->auction_step
                ],
            ]),
            $this->mergeWhen(is_null($this->auction_step), [
                'stepPrice' => null
            ]),
            $this->mergeWhen(!is_null($this->deposit), [
                'deposit' => [
                    'type' => $this->is_deposit_rub ? 'rubles' : 'percent',
                    'value' => $this->deposit
                ],
            ]),
            $this->mergeWhen(is_null($this->deposit), [
                'deposit' => null
            ]),
            'priceReduction' => $priceReduction,
            'currentPrice' => (float)$this->current_price,
            'minPrice'=> (float)$this->min_price,
            'currentPriceState' => $this->current_price_state,
            'link' => URL::to('/lot/' . $this->id),
            'efrsbLink' => 'https://fedresurs.ru/bidding/' . $this->auction->guid
        ];
    }


}
