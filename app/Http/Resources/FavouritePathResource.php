<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavouritePathResource extends JsonResource
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
            'pathId'=>$this->id,
            'name'=>$this->title,
            'color'=>$this->color,
            'lotCount'=>$this->lots_count,
            'main'=>$this->main
        ];
    }
}
