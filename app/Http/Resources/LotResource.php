<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Note;
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
        $user = auth()->guard('api')->user();
        $inFavourite = auth()->guard('api')->check() ? $this->inFavourite() : false;
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
        $serialized = array_map('serialize', $parents);
        $unique = array_unique($serialized);
        $parents = array_intersect_key($parents, $unique);
        foreach ($parents as $category) {
            $subs = array_intersect($category->subcategories()->pluck('id')->toArray(), $categoriesIds);
            $subs = Category::whereIn('id', array_unique($subs))->get();
            $subcategories = [];
            foreach($subs as $sub){
                $value = ['label'=>$sub->label, 'key'=>$sub->title];
                if(!in_array($value, $subcategories)) {
                    $subcategories[] = $value;
                }
            }
            $categories[] = ['label'=>$category->label, 'key'=>$category->title, 'subcategories'=>$subcategories];
        }
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
            'isWatched' => auth()->guard('api')->check() ? $user->seenLots->pluck('id')->contains($this->id) : false,
            'isPinned' => auth()->guard('api')->check() ? $user->fixedLots->pluck('id')->contains($this->id) : false,
            'inFavourite' => $inFavourite,
            $this->mergeWhen($inFavourite === true, [
                'favouritePaths' => FavouritePathResource::collection($user->favourites()->whereHas('lots', function($query){
                    $query->where('lot_id', $this->id);
                })->get()),
            ]),
            'isHide' => auth()->guard('api')->check() ? $user->hiddenLots->pluck('id')->contains($this->id) : false,
            'inMonitoring' => auth()->guard('api')->check() ? $this->inMonitoring() : false,
            'startPrice' =>  (float)$this->start_price,
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
            'marks'=> $this->userMarks()->makeHidden(['pivot']),
            'descriptionExtracts'=>$params->makeHidden(['pivot']),
            $this->mergeWhen(($this->isLotInfo && !is_null($this->getNote())), [
                'note'=> $this->getNote()
            ])
        ];
    }


}
