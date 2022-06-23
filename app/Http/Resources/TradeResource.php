<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'lotCount' => $this->lots->count(),
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
                'externalId' => $this->trade_id,
                'publishDateSmi' => $this->date_publish_efir,
                'publishDateEfir' => $this->date_publish_smi,
                'type' => $this->auctionType->title,
                'state' => '',
                'priceOfferForm' => $this->price_form,
                'organizer' => [
                    'type' => $this->companyTradeOrganizer->type,
                    $this->mergeWhen($this->companyTradeOrganizer->type === 'person', [
                        'person' => [
                            'firstName' => $this->companyTradeOrganizer->name,
                            'middleName' => $this->companyTradeOrganizer->middle_name,
                            'lastName' => $this->companyTradeOrganizer->last_name
                        ],
                        'company' => null
                    ]),
                    $this->mergeWhen($this->companyTradeOrganizer->type === 'company', [
                        'person' => null,
                        'company' => [
                            'shortName' => $this->companyTradeOrganizer->short_name,
                            'fullName' => $this->companyTradeOrganizer->name
                        ]
                    ])
                ],
                'arbitrManager' => [
                    'type' => $this->arbitrManager->type,
                    $this->mergeWhen($this->arbitrManager->type === 'person', [
                        'person' => [
                            'firstName' => $this->arbitrManager->name,
                            'middleName' => $this->arbitrManager->middle_name,
                            'lastName' => $this->arbitrManager->last_name
                        ],
                        'company' => null
                    ]),
                    $this->mergeWhen($this->arbitrManager->type === 'company', [
                        'person' => null,
                        'company' => [
                            'shortName' => $this->arbitrManager->short_name,
                            'fullName' => $this->arbitrManager->name
                        ]
                    ])
                ],
                'debtorId' => $this->debtor_id,
                'tradePlace' => [
                    'name' => $this->tradePlace->name,
                    'site' => $this->tradePlace->site
                ]

            ]),
        ];
    }
}
