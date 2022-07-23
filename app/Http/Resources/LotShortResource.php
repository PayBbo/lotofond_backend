<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LotShortResource extends JsonResource
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
            'lotNumber' => $this->number,
            'photos' => $this->photos,
            'description' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->description)),
            'currentPrice' => (float)$this->current_price,
            'externalId' => $this->auction->trade_id,
            'eventTime' => [
                'start' => $this->auction->event_start_date,
                'end' => $this->auction->event_end_date,
                'result' => $this->auction->result_date,
            ],
            'organizer' => new BidderResource($this->auction->companyTradeOrganizer),
            'tradePlaceSite' => str_starts_with($this->auction->tradePlace->site, 'http')
                ? $this->auction->tradePlace->site : 'http://' . $this->auction->tradePlace->site

        ];
    }
}
