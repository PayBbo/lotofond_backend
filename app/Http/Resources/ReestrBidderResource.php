<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReestrBidderResource extends JsonResource
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
            'type' => $this->type,
            'id' => $this->id,
            'inn' => $this->inn,
            $this->mergeWhen($this->type === 'person', [
                'person' => [
                    'firstName' => $this->name,
                    'middleName' => $this->middle_name,
                    'lastName' => $this->last_name
                ],
                'company' => null
            ]),
            $this->mergeWhen($this->type === 'company', [
                'person' => null,
                'company' => [
                    'shortName' => $this->short_name,
                    'fullName' => $this->name
                ]
            ]),
            $this->mergeWhen($this->role == 'arbitrationManager', [
                'arbitrationManager' => [
                    'sro' => $this->sroAu ? $this->sroAu->name : null,
                    'regDate' => $this->reg_date,
                    'regNum' => $this->reg_num,
                    'rating' => new RatingResource($this)
                ]
            ]),
            $this->mergeWhen($this->role == 'organizer', [
                'organizer' => [
                    'region' => $this->region ? $this->region->code : null,
                    'address' => $this->address,
                    'ogrn' => $this->ogrn,
                    'rating' =>  new RatingResource($this)
                ]
            ]),
            $this->mergeWhen($this->role == 'debtor', [
                'debtor' => [
                    'region' => $this->region ? $this->region->code : null,
                    'address' => $this->address,
                    'ogrn' => $this->ogrn,
                    'category' => $this->debtorCategory ? $this->debtorCategory->code : null,
                ]
            ]),
        ];
    }
}
