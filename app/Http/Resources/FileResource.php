<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'files'=>$this->lotFiles()->where('type', 'file')->pluck('url'),
            'userFiles'=>auth()->check() ? $this->userLotFiles()->where('type', 'file')->select('id', 'url')->get() : [],
            'images'=>$this->photos
        ];
    }
}
