<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\PaginationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EgrnStatementCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = 'App\Http\Resources\Admin\EgrnStatementResource';

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' => new PaginationResource($this)
        ];
    }
}
