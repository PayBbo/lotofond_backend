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
        $this->auction->isLotInfo = $this->isLotInfo;
        $regions = $this->regions()->select('code', 'lot_regions.is_debtor_region as isDebtorRegion')->get();
        return [
            'id' => $this->id,
            'trade' => new TradeResource($this->auction),
            'lotNumber' => $this->number,
            'photos' => $this->photos,
            'categories' => $this->categoriesStructure(),
            'description' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->description)),
            'state' => $this->status->code,
            'location' => $regions->makeHidden(['pivot']),
            'isWatched' => auth()->guard('api')->check() ? $user->seenLots->pluck('id')->contains($this->id) : false,
            'isPinned' => auth()->guard('api')->check() ? $user->fixedLots->pluck('id')->contains($this->id) : false,
            'inFavourite' => $inFavourite,
            'hasNotSeenNotification'=>auth()->guard('api')->check() ? $this->hasNotSeenNotification() : false,
            $this->mergeWhen($inFavourite  && !is_null($this->getLotFavouritePaths()), [
                'favouritePaths' => $this->getLotFavouritePaths(),
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
            'descriptionExtracts'=>$this->description_extracts,
            $this->mergeWhen(($this->isLotInfo && !is_null($this->getNote())), [
                'note'=> $this->getNote()
            ]),
            $this->mergeWhen(($this->isLotInfo ), [
                'requirementsForParticipants'=>$this->participants,
                'paymentInfo'=>$this->payment_info,
                'saleAgreement'=>$this->sale_agreement,
                'biddingInfo' => $this->concours,
                'applicationRules'=>$this->auction->application_rules
            ])
        ];
    }


}
