<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VictoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $startPrice = (float)$this->tradeMessage->lot->start_price;
        $endPrice = (float)$this->end_price;
        $percentageReduction = round((1 - $endPrice / $startPrice) * 100, 1);
        return [
            'tradeId'=>$this->tradeMessage->lot->auction->trade_id,
            'description'=>stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->tradeMessage->lot->description)),
            'photos'=>$this->tradeMessage->lot->photos,
            'startPrice'=>$startPrice,
            'endPrice'=>$endPrice,
            'percentageReduction'=>$percentageReduction,
            'date'=>$this->created_at,
            'participantsCount'=>$this->biddingParticipants->count(),
            'winner'=>[
                $this->mergeWhen($this->winner->first()->bidder->type === 'person', [
                    'person' => [
                        'firstName' => $this->winner->first()->bidder->name,
                        'middleName' => $this->winner->first()->bidder->middle_name,
                        'lastName' => $this->winner->first()->bidder->last_name
                    ],
                    'company' => null
                ]),
                $this->mergeWhen($this->winner->first()->bidder->type === 'company', [
                    'person' => null,
                    'company' => [
                        'shortName' => $this->winner->first()->bidder->short_name,
                        'fullName' => $this->winner->first()->bidder->name
                    ]
                ]),
                'victoriesCount'=>$this->winner->first()->bidder->biddingVictories->count()
            ]
        ];
    }
}
