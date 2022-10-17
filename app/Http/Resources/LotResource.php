<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Note;
use App\Models\PriceReduction;
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
        $inFavourite = auth()->guard('api')->check() && $this->favouritePaths->count() > 0;
        $this->auction->isLotInfo = $this->isLotInfo;
        $regions = $this->showRegions;
        $priceReductions = $this->showPriceReductions()->select('id', 'start_time as time', 'price')->get();
        $currentPrice = $this->start_price;
        $currentPriceState = 'hold';
        $currentPriceRed = $this->currentPriceReduction;
        foreach ($priceReductions as $priceReduction) {
            $priceReduction->isCurrentStage = false;
            if ($currentPriceRed) {
                if ($priceReduction->id == $currentPriceRed['id']) {
                    $priceReduction->isCurrentStage = true;
                }
            }
        }
        if ($currentPriceRed) {
            $currentPrice = (float)$currentPriceRed['price'];
            $prev = PriceReduction::where('lot_id', $this->id)
                ->where('id', '<', $currentPriceRed['id'])
                ->latest('id')
                ->first();
            $prevPrice = (float)$this->start_price;
            if ($prev) {
                $prevPrice = (float)$prev['price'];
            }
            if ($prevPrice > $currentPrice) {
                $currentPriceState = 'down';
            } elseif ($prevPrice < $currentPrice) {
                $currentPriceState = 'up';
            }

        }
        return [
            'id' => $this->id,
            'trade' => new TradeResource($this->auction),
            'lotNumber' => $this->number,
            'photos' => $this->photos,
            'categories' => $this->categoriesStructure(),
            'description' => $this->description,
            'state' => $this->status->code,
            'location' => $regions->makeHidden(['pivot']),
            'isWatched' => auth()->guard('api')->check() ? $user->seenLots->pluck('id')->contains($this->id) : false,
            'isPinned' => auth()->guard('api')->check() ? $user->fixedLots->pluck('id')->contains($this->id) : false,
            'inFavourite' => $inFavourite,
            'hasNotSeenNotification' => auth()->guard('api')->check() ? $this->hasNotSeenNotification() : false,
            $this->mergeWhen($inFavourite, [
                'favouritePaths' => FavouritePathResource::collection($this->favouritePaths),
            ]),
            'isHide' => auth()->guard('api')->check() ? $user->hiddenLots->pluck('id')->contains($this->id) : false,
            'inMonitoring' => auth()->guard('api')->check() && $this->monitoringPaths->count() > 0,
            'startPrice' => (float)$this->start_price,
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
            'priceReduction' => $priceReductions,
            'currentPrice' => $currentPrice,
            'minPrice' => (float)$this->min_price,
            'currentPriceState' => $currentPriceState,
            'link' => URL::to('/lot/' . $this->id),
            'efrsbLink' => 'https://fedresurs.ru/bidding/' . $this->auction->guid,
            'marks' => $this->userMarks()->makeHidden(['pivot']),
            'descriptionExtracts' => $this->description_extracts,
            // $this->mergeWhen(!is_null($this->getNote()), [
            'note' => $this->getNote(),
            // ]),
            $this->mergeWhen(($this->isLotInfo), [
                'requirementsForParticipants' => $this->participants,
                'paymentInfo' => $this->payment_info,
                'saleAgreement' => $this->sale_agreement,
                'biddingInfo' => $this->concours,
                'applicationRules' => $this->auction->application_rules
            ])
        ];
    }


}
