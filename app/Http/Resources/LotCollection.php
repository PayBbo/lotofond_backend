<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class LotCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = 'App\Http\Resources\LotResource';

    protected $content;

    public function content($content){
        $this->content = $content;
        return $this;
    }


    public function toArray($request)
    {
        return [
            'data' => $this->collection->each->content($this->content),
            'pagination' => new PaginationResource($this)
         ];
    }
}
