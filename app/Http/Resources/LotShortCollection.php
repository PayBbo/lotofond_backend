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

    protected $contentRules;

    public function contentRules($contentRules=null){
        $this->contentRules = $contentRules;
        return $this;
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection->each->contentRules($this->contentRules),
            'pagination' => new PaginationResource($this)
        ];
    }
}
