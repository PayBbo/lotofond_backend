<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
    public $collects = 'App\Http\Resources\Admin\UserResource';


    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' => new PaginationResource($this)
        ];
    }
}
