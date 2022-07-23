<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LotShortCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $collects = 'App\Http\Resources\LotShortResource';

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' => new PaginationResource($this)
        ];
    }
}
