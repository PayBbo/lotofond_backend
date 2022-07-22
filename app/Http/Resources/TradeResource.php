<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class TradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'externalId' => $this->trade_id,
            'lotCount' => $this->lots->count(),
            'type' => $this->auctionType->title,
            'publishDate'=> $this->publish_date,
            'eventTime' => [
                'start' => $this->event_start_date,
                'end' => $this->event_end_date,
                'result' => $this->result_date,
            ],
            'applicationTime' => [
                'start' => $this->application_start_date,
                'end' => $this->application_end_date,
            ],
            $this->mergeWhen($this->isLotInfo === true, [
                'publishDateSmi' => $this->date_publish_efir,
                'publishDateEfir' => $this->date_publish_smi,
                'priceOfferForm' => $this->price_form,
                'organizer' => new BidderResource($this->companyTradeOrganizer),
                'arbitrationManager' => new BidderResource($this->arbitrationManager),
                'debtor' => new BidderResource($this->debtor),
                'tradePlace' => [
                    'name' => $this->tradePlace->name,
                    'site' => str_starts_with($this->tradePlace->site, 'http') ? $this->tradePlace->site : 'http://'.$this->tradePlace->site
                ]

            ]),
            $this->mergeWhen(Route::getCurrentRoute()->getName() === 'bidders-trades', [
                'organizer' => new BidderResource($this->companyTradeOrganizer),
                'tradePlace' => [
                    'name' => $this->tradePlace->name,
                    'site' => str_starts_with($this->tradePlace->site, 'http') ? $this->tradePlace->site : 'http://'.$this->tradePlace->site
                ]

            ]),
        ];
    }
}
