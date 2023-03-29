<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'id'=>$this->id,
            'header'=>$this->title,
            'description'=>$this->description,
            'detailedDescription'=>$this->included_details,
            'price'=>$this->price,
            'type'=>$this->code
        ];
    }
}
