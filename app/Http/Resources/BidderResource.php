<?php

namespace App\Http\Resources;

use App\Models\Type;
use Illuminate\Http\Resources\Json\JsonResource;

class BidderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'type' => $this->type,
            'id'=>$this->id,
            'inn'=>$this->inn,
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
            'region'=>is_null($this->region) ? null : $this->region->code,
            'address'=>$this->address,
            'sro'=>is_null($this->sro_au_id) ? null : $this->sroAu->name

        ];
    }
}
