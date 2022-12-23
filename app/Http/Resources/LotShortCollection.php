<?php

namespace App\Http\Resources;

use App\Http\Services\ContentSettingsService;
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

    protected $contentSettings;

    public function __construct($resource)
    {
        $this->contentSettings = new ContentSettingsService();
        parent::__construct($resource);
    }



    public function toArray($request)
    {
        return [
            'data' => $this->collection->each->contentRules($this->contentSettings),
            'pagination' => new PaginationResource($this)
        ];
    }
}
