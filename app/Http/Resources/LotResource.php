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
        logger($this->categories);
        foreach ($this->categories as $category) {
            if (!is_null($category->parent())) {
                $parents[] = $category->parent();
            } else {
                $parents[] = $category;
            }
        }
        $categoriesIds = $this->categories->pluck('id')->toArray();
        foreach ($parents as $category) {
            $tmp_subs = array_intersect($category->subcategories()->pluck('id')->toArray(), $categoriesIds);
            $subs = Category::whereIn('id', $tmp_subs)->get();
            $subcategories = [];
            foreach($subs as $sub){
                $value = ['label'=>$sub->label, 'key'=>$sub->title];
                if(!in_array($value, $subcategories)) {
                    $subcategories[] = $value;
                }
            }
            $categories[] = ['label'=>$category->label, 'key'=>$category->title, 'subcategories'=>$subcategories];
        }
        logger($categories);
        $this->auction->isLotInfo = $this->isLotInfo;
        $params = $this->params()->select('title', 'type', 'lot_params.value')->get();
        return [
            'id' => $this->id,
            'trade' => new TradeResource($this->auction),
            'lotNumber' => $this->number,
            'photos' => $this->photos,
            'categories' => $categories,
            'description' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->description)),
            'state' => $this->status->code,
            'location' => $this->auction->debtor->region ? $this->auction->debtor->region->code : null,
            'isWatched' => auth()->check() ? $user->seenLots->contains($this->id) : false,
            'isPinned' => auth()->check() ? $user->fixedLots->contains($this->id) : false,
            'inFavourite' => auth()->check() ? $this->inFavourite() : false,
            'isHide' => auth()->check() ? $user->hiddenLots->contains($this->id) : false,
            'inMonitoring' => auth()->check() ? $this->inMonitoring() : false,
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
            'priceReduction' => $this->has('priceReductions') ? $this->showPriceReductions()->select('start_time as time', 'price')->get() : null,
            'currentPrice' => (float)$this->current_price,
            'minPrice'=> (float)$this->min_price,
            'currentPriceState' => $this->current_price_state,
            'link' => URL::to('/lot/' . $this->id),
            'efrsbLink' => 'https://fedresurs.ru/bidding/' . $this->auction->guid,
            'marks'=> $this->userMarks,
            'description_extracts'=>$params->makeHidden(['pivot'])
        ];
    }


}
