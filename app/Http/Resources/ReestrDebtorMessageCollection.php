<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReestrDebtorMessageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $collects = 'App\Http\Resources\ReestrDebtorMessageResource';

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' => new PaginationResource($this)
        ];
    }
}
