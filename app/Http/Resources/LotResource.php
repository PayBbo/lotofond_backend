<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Favourite;
use App\Models\Monitoring;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

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
        return [
            'auctionId' => $this->auction_id,
            'lotId' => $this->id,
            'isWatched' => auth()->check() ? $user->seenLots->contains($this->id) : false,
            'categories' => $categories,
            'isPinned' => auth()->check() ? $user->fixedLots->contains($this->id) : false,
            'inFavourite' => auth()->check() ? Favourite::where(['user_id' => $user->id, 'lot_id' => $this->id])->exists() : false,
            'isHide' => auth()->check() ? $user->hiddenLots->contains($this->id) : false,
            'label' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->description)),
            'date' => $this->auction->publish_date->format('d.m.Y H:i'),
            'state' => $this->status->title,
            'tradingNumber' => $this->auction->trade_id,
            'lotNumber' => $this->number,
            'photos' => is_null($this->images) ? [] : $this->images,
            'geoPosition' => $this->auction->debtor->address,
            'numberOfLots' => $this->auction->lots->count(),
            'price' => $this->price,
            'priceState' => $this->price_state,
            'tags' => [],
            'inMonitoring' => auth()->check() ? Monitoring::where(['user_id' => $user->id, 'lot_id' => $this->id])->exists() : false,
            'auctionStep' => $this->auction_step,
            'isAuctionStepRub' => is_null($this->is_step_rub),
            'deposit' => $this->deposit,
            'isDepositRub' => $this->is_deposit_rub,
            $this->mergeWhen($this->isLotInfo === true, [
                'tradePlaceName' => $this->auction->tradePlace->name,
                'tradePlaceSite' => $this->auction->tradePlace->site,
                'arbitrManagerID' => $this->auction->arbitr_manager_id,
                'arbitrManagerName' => $this->auction->arbitrManager->name,
                'tradeOrganizerID' => $this->auction->company_trade_organizer_id,
                'tradeOrganizerName' => $this->auction->companyTradeOrganizer->name,
                'tradeOrganizerINN' => $this->auction->companyTradeOrganizer->inn,
                'debtorID' => $this->auction->debtor_id,
                'auctionType' => $this->auction->auctionType->title,
                'eventStart' => is_null($this->auction->event_start_date) ? null : $this->auction->event_start_date->format('d.m.Y H:i'),
                'eventEnd' => is_null($this->auction->event_end_date) ? null : $this->auction->event_end_date->format('d.m.Y H:i'),
                'applicationStart' => is_null($this->auction->application_start_date) ? null : $this->auction->application_start_date->format('d.m.Y H:i'),
                'applicationEnd' => is_null($this->auction->application_end_date) ? null : $this->auction->application_end_date->format('d.m.Y H:i'),
                'resultDate' => is_null($this->auction->result_date) ? null : $this->auction->result_date->format('d.m.Y H:i'),
            ]),
        ];
    }
}
