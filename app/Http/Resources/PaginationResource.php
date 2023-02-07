<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    protected $isPagination;

    public function __construct($resource, $isPagination=true)
    {
        $this->isPagination = $isPagination;

        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $numberOfLotsForUnauthorizedUsers = (int)config('auth.numberOfLotsForUnauthorizedUsers');
        $isPagination = $this->isPagination;

        return [
            'total' => $isPagination ? $this->total() : $numberOfLotsForUnauthorizedUsers,
            'count' => $this->count(),
            'perPage' => $isPagination ? $this->perPage() : $numberOfLotsForUnauthorizedUsers,
            'currentPage' => $isPagination ? $this->currentPage() : 1,
            'lastPage' => $isPagination ? $this->lastPage() : 1,
            'from' => $isPagination ? $this->firstItem() : 1,
            'nextPageUrl' => $isPagination ? $this->nextPageUrl() : null,
            'to' => $isPagination ? $this->lastItem() : $numberOfLotsForUnauthorizedUsers,
            'prevPageUrl' => $isPagination ? $this->previousPageUrl() : null,
        ];
    }
}
