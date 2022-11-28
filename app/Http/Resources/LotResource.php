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
        $authCheck = auth()->guard('api')->check();
        $inFavourite = $authCheck && $this->favouritePaths->count() > 0;
        $this->auction->isLotInfo = $this->isLotInfo;
        $regions = $this->showRegions;
        $priceReductions = $this->showPriceReductions->makeHidden('lot_id');
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
            $prev = $this->prevPrice;
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
            'isWatched' => $authCheck ? $user->seenLots->pluck('id')->contains($this->id) : false,
            'isPinned' => $authCheck ? $user->fixedLots->pluck('id')->contains($this->id) : false,
            'inFavourite' => $inFavourite,
            'hasNotSeenNotification' => $authCheck ? $this->hasNotSeenNotification() : false,
            $this->mergeWhen($inFavourite, [
                'favouritePaths' => FavouritePathResource::collection($this->favouritePaths),
            ]),
            'isHide' => $authCheck ? $user->hiddenLots->pluck('id')->contains($this->id) : false,
            'inMonitoring' => $authCheck && $this->monitoringPaths->count() > 0,
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
            $this->mergeWhen($this->auction->auctionType->title == 'PublicOffer' || $this->auction->auctionType->title == 'ClosePublicOffer', [
                'priceReduction' => $priceReductions,
                $this->mergeWhen(strlen((string)$this->price_reduction) > 0 && $this->price_reduction != '<table></table>', [
                    'priceReductionHtml' => '<!DOCTYPE HTML><html lang="ru">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8"/>
    <style type="text/css">  p {font-size: max(1em, min(4em, calc(100vw * 4 / 75)));line-height: 2em;}</style>
  </head>
  <body>
<p>' . $this->price_reduction . '</p>
    <script type="text/javascript">
      const resizeObserver = new ResizeObserver(entries =>Resize.postMessage("height" + (entries[0].target.clientHeight).toString()));
      resizeObserver.observe(document.body);
    </script>
</body>
</html>',
                ]),
                $this->mergeWhen(strlen((string)$this->price_reduction) == 0 || $this->price_reduction == '<table></table>', [
                    'priceReductionHtml' => null
                ]),

            ]),
            'currentPrice' => $currentPrice,
            'minPrice' => (float)$this->min_price,
            'currentPriceState' => $currentPriceState,
            'link' => URL::to('/lot/' . $this->id),
            'efrsbLink' => 'https://fedresurs.ru/bidding/' . $this->auction->guid,
            'marks' => $this->userMarks->makeHidden(['pivot']),
            'descriptionExtracts' => $this->description_extracts,
            'note' => $this->getNote(),
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
