<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VictoryResource extends JsonResource
{
    protected $contentSettings;

    public function content($settings)
    {
        $this->contentSettings = $settings;
        return $this;
    }
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
        if($startPrice>$endPrice) {
            $direction = 'down';
            $percentageReduction = round(($startPrice - $endPrice) / $startPrice * 100, 1);
        }else{
            $direction = 'up';
            $percentageReduction =  round(($endPrice - $startPrice) / $startPrice * 100, 1);
        }
        return [
            'tradeId'=> $this->contentSettings->isAvailable( 'externalId') ? $this->tradeMessage->lot->auction->trade_id : null,
            'description'=> $this->contentSettings->isAvailable('descriptionExtracts') ? $this->tradeMessage->lot->description : $this->tradeMessage->lot->processed_description,
            'photos'=>$this->contentSettings->isAvailable('photos') ? $this->tradeMessage->lot->photos : null,
            'categories' => $this->contentSettings->isAvailable('categories') ?  $this->tradeMessage->lot->categoriesStructure() : null,
            'startPrice'=> $this->contentSettings->isAvailable('startPrice') ? $startPrice : null,
            'endPrice'=>$endPrice,
            'percentageDirection'=>$direction,
            'percentageReduction'=>$percentageReduction ?? 0,
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
