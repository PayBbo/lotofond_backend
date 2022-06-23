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
            $categories[$category->title] = Category::whereIn('id', $subs)->get()->pluck('title')->toArray();
        }
        $this->auction->isLotInfo = $this->isLotInfo;
        return [
            'id' => $this->id,
            'trade' => new TradeResource($this->auction),
            'lotNumber' => $this->number,
            'photos' => is_null($this->images) ? [] : $this->images,
            'categories' => $categories,
            'description' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->description)),
            'state' => $this->status->title,
            'location' => $this->auction->debtor->address,
            'isWatched' => auth()->check() ? $user->seenLots->contains($this->id) : false,
            'isPinned' => auth()->check() ? $user->fixedLots->contains($this->id) : false,
            'inFavourites' => auth()->check() ? Favourite::where(['user_id' => $user->id, 'lot_id' => $this->id])->exists() : false,
            'isHide' => auth()->check() ? $user->hiddenLots->contains($this->id) : false,
            'inMonitoring' => auth()->check() ? Monitoring::where(['user_id' => $user->id, 'lot_id' => $this->id])->exists() : false,
            'startPrice' => $this->start_price,
            'stepPrice'=>[
                'type'=> $this->is_step_rub ? 'rubles' : 'percent',
                'value'=>$this->auction_step
            ],
            'deposit'=>[
                'type'=> $this->is_deposit_rub ? 'rubles' : 'percent',
                'value'=>$this->deposit
            ],
            'priceState' => $this->price_state,
            'priceReduction'=>$this->price_reduction,
            'currentPrice'=>$this->current_price,
            'currentPriceState'=>$this->current_price_state,
            'link'=> URL::to('/lot/'.$this->id),
            'efrsbLink' => 'https://fedresurs.ru/bidding/'. $this->auction->guid
        ];
    }

    public static function collection($data)
    {
        if (is_a($data, \Illuminate\Pagination\AbstractPaginator::class)) {
            $data->setCollection(
                $data->getCollection()->map(function ($listing) {
                    return new static($listing);
                })
            );

            return $data;
        }

        return parent::collection($data);
    }
}
