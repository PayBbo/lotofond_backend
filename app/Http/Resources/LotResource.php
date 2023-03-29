<?php

namespace App\Http\Resources;

use App\Http\Services\ContentSettingsService;
use App\Models\Category;
use App\Models\ContentRule;
use App\Models\Note;
use App\Models\PriceReduction;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class LotResource extends JsonResource
{
    protected $authCheck;
    protected $contentSettings;
    protected $content;

    public function content($settings, $authCheck, $content = null)
    {
        $this->content = $content;
        $this->authCheck = $authCheck;
        $this->contentSettings = $settings;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $authCheck = $this->authCheck;
        $inFavourite = false;
        $favouritePaths = [];
        if ($authCheck && $this->contentSettings->isAvailable('hasAccessToFavourite')) {
            foreach ($this->content['favouritesLots'] as $favourite) {
                if (in_array($this->id, $favourite['lotIds'])) {
                    $inFavourite = true;
                    $favouritePaths[] = (object)$favourite['path'];
                }
            }
        }
        $this->auction->isLotInfo = $this->isLotInfo;
        $regions = $this->contentSettings->isAvailable('location') ? $this->showRegions->makeHidden(['pivot']) : null;
        $currentPrice = $this->contentSettings->isAvailable('currentPrice') ? $this->start_price : null;
        $currentPriceState = $this->contentSettings->isAvailable('currentPriceState') ? 'hold' : null;
        $currentPriceRed = null;
        $isPublicOffer = $this->auction->auctionType->title == 'PublicOffer' || $this->auction->auctionType->title == 'ClosePublicOffer';
        if (($this->contentSettings->isAvailable('currentPrice') || $this->contentSettings->isAvailable('currentPriceState'))) {
            $currentPriceRed = $this->currentPriceReduction;
            if ($currentPriceRed) {
                if ($this->contentSettings->isAvailable('currentPrice')) {
                    $currentPrice = (float)$currentPriceRed['price'];
                }
                if ($this->contentSettings->isAvailable('currentPriceState')) {
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

            }
        }
        $monitoringLots = [];
        if (auth()->guard('api')->check()) {
            $monitoringLots = $this->content['monitoringLots'];
        }

        $lotData = [
            'id' => $this->id,
            'trade' => (new TradeResource($this->auction))->content($this->contentSettings),
            'lotNumber' => $this->contentSettings->isAvailable('lotNumber') ? $this->number : null,
            'photos' => $this->contentSettings->isAvailable('photos') ? $this->photos : null,
            'categories' => $this->contentSettings->isAvailable('categories') ? $this->categoriesStructure() : null,
            'description' => $this->contentSettings->isAvailable('descriptionExtracts') ? $this->description : $this->processed_description,
            'state' => $this->contentSettings->isAvailable('state') ? $this->status->code : null,
            'location' => $regions,
            'isWatched' => $authCheck && in_array($this->id, $this->content['seenLots']),
            'isPinned' => $authCheck && in_array($this->id, $this->content['fixedLots']),
            'inFavourite' => $inFavourite,
            $this->mergeWhen($inFavourite, [
                'favouritePaths' => FavouritePathResource::collection($favouritePaths)
            ]),
            'hasNotSeenNotification' => $authCheck && in_array($this->id, $this->content['notSeenNots']),
            'isHide' => $authCheck && in_array($this->id, $this->content['hiddenLots']),
            'inMonitoring' => $this->contentSettings->isAvailable('hasAccessToMonitoring') && in_array($this->id, $monitoringLots),
            'startPrice' => $this->contentSettings->isAvailable('startPrice') ? (float)$this->start_price : null,
            $this->mergeWhen(!is_null($this->auction_step) && $this->contentSettings->isAvailable('stepPrice') && !$isPublicOffer, [
                'stepPrice' => [
                    'type' => $this->is_step_rub ? 'rubles' : 'percent',
                    'value' => $this->auction_step
                ],
            ]),
            $this->mergeWhen(is_null($this->auction_step) || !$this->contentSettings->isAvailable('stepPrice') ||  $isPublicOffer, [
                'stepPrice' => null
            ]),
            $this->mergeWhen(!is_null($this->deposit) && $this->contentSettings->isAvailable('deposit'), [
                'deposit' => [
                    'type' => $this->is_deposit_rub ? 'rubles' : 'percent',
                    'value' => $this->deposit
                ],
            ]),
            $this->mergeWhen(is_null($this->deposit) || !$this->contentSettings->isAvailable('deposit'), [
                'deposit' => null
            ]),
            'currentPrice' => $currentPrice,
            'minPrice' => $this->contentSettings->isAvailable('minPrice') && $isPublicOffer ? $this->min_price : null,
            'currentPriceState' => $currentPriceState,
            'link' => URL::to('/lot/' . $this->id),
            'efrsbLink' => $this->contentSettings->isAvailable('efrsbLink') ? 'https://fedresurs.ru/bidding/' . $this->auction->guid : null,
            'descriptionExtracts' => $this->contentSettings->isAvailable('descriptionExtracts') ? $this->description_extracts : null,
            /*  $this->mergeWhen(($this->isLotInfo), [
           'requirementsForParticipants' => $this->participants,
            'paymentInfo' => $this->payment_info,
            'saleAgreement' => $this->sale_agreement,
            'biddingInfo' => $this->concours,
            'applicationRules' => $this->auction->application_rules
      ])*/
        ];
        if ($this->isLotInfo) {
            $priceReductions = null;
            if ($this->contentSettings->isAvailable('priceReduction') && $isPublicOffer) {
                $priceReductions = $this->showPriceReductions->makeHidden('lot_id');
                foreach ($priceReductions as $priceReduction) {
                    $priceReduction->isCurrentStage = false;
                    if ($currentPriceRed) {
                        if ($priceReduction->id == $currentPriceRed['id']) {
                            $priceReduction->isCurrentStage = true;
                        }
                    }
                }
            }
            if ($this->contentSettings->isAvailable('priceReduction') && $isPublicOffer) {
                $lotData['priceReduction'] = $priceReductions;
                if (strlen((string)$this->price_reduction) > 0 && $this->price_reduction != '<table></table>') {
                    $lotData['priceReductionHtml'] = '<!DOCTYPE HTML><html lang="ru">
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
</html>';
                } else {
                    $lotData['priceReductionHtml'] = null;
                }
            }
            if ($authCheck) {
                $lotData['applications'] = ApplicationResource::collection($this->userApplications);
                $lotData['note'] = $this->getNote();
                $lotData['marks'] = $this->userMarks->makeHidden(['pivot']);
               /* $additionalInfo = $this->additionalLotInfo();
                if($additionalInfo){
                    $lotData['organizerAnswer'] = '<!DOCTYPE HTML><html lang="ru">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8"/>
    <style type="text/css">  p {font-size: max(1em, min(4em, calc(100vw * 4 / 75)));line-height: 2em;}</style>
  </head>
  <body>
<p>' . $additionalInfo->message . '</p>
    <script type="text/javascript">
      const resizeObserver = new ResizeObserver(entries =>Resize.postMessage("height" + (entries[0].target.clientHeight).toString()));
      resizeObserver.observe(document.body);
    </script>
</body>
</html>';
                }*/
            }
        }
        return $lotData;
    }


}
