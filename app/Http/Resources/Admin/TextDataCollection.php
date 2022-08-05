<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\PaginationResource;
use App\Models\TextData;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TextDataCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = 'App\Http\Resources\TextDataResource';

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'types'=>TextData::select('screen', 'type')->groupBy('screen', 'type')->get()->toArray(),
            'pagination' => new PaginationResource($this)
        ];
    }
}
