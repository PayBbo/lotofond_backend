<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class NewsResource extends JsonResource
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
            'description'=>!is_null($this->description) ? $this->description : '',
            'image'=>!is_null($this->image) ? URL::to('/') . '/' . $this->image : null,
            'isBanner'=>$this->is_banner,
            'publishDate'=>$this->created_at->format('d.m.Y H:i')
        ];
    }
}
