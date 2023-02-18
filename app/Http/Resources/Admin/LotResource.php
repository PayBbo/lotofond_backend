<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\FavouritePathResource;
use App\Http\Resources\TradeResource;
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
        }
        return [
            'id' => $this->id,
            'tradeNumber' => $this->auction->trade_id,
            'tradeType' => $this->auction->auctionType->title,
            'description' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->description)),
            'startPrice' => $this->start_price,
            'status' => $this->status->value,
            $this->mergeWhen(($this->isLotInfo), [
                'publishDate' => is_null($this->auction->publish_date) ? null : $this->auction->publish_date->format('d.m.Y H:i'),
                'eventTimeStart' => is_null($this->auction->event_start_date) ? null : $this->auction->event_start_date->format('d.m.Y H:i'),
                'eventTimeEnd' => is_null($this->auction->event_end_date) ? null : $this->auction->event_end_date->format('d.m.Y H:i'),
                'eventTimeResult' => is_null($this->auction->result_date) ? null : $this->auction->result_date->format('d.m.Y H:i'),
                'applicationTimeStart' => is_null($this->auction->application_start_date) ? null : $this->auction->application_start_date->format('d.m.Y H:i'),
                'applicationTimeEnd' => is_null($this->auction->publish_date) ? null : $this->auction->application_end_date->format('d.m.Y H:i'),
                'lotNumber' => $this->number,
                'images'=>$this->lotFiles()->where('type', 'image')->where('user_id', null)->select('id', 'url')->get(),
                'files'=> $this->lotFiles()->where('type', 'file')->select('id', 'url')->get(),
                'categories' => $this->categoriesStructure(),
                'location' => $regions->makeHidden(['pivot']),
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
                'priceReduction' => $this->price_reduction,
                'currentPrice' => $currentPrice,
                'minPrice' => (float)$this->min_price,
                'link' => URL::to('/lot/' . $this->id),
                'efrsbLink' => 'https://fedresurs.ru/bidding/' . $this->auction->guid,
                'descriptionExtracts' => $this->description_extracts,
            ])

        ];
    }
}
