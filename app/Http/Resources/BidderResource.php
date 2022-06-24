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
             $this->mergeWhen($this->types->contains(Type::where('title','organizer')->first()), [
                 'phone'=>$this->phone,
                 'email'=>$this->email
             ]),
            $this->mergeWhen($this->types->contains(Type::where('title','arbitrManager')->first()), [
                'sroAU'=>$this->sroAu ? $this->sroAu->name : null,
            ]),
        ];
    }
}
