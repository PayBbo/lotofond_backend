<?php

namespace App\Http\Resources;

use App\Http\Services\ContentSettingsService;
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
    protected $contentSettings;
    protected $authCheck;

    public function content($contentSettings, $authCheck){
        $this->content = $authCheck ? $contentSettings->getUserData() : null;
        $this->contentSettings = $contentSettings;
        $this->authCheck = $authCheck;
        return $this;
    }


    public function toArray($request)
    {
        return [
            'data' => $this->collection->each->content($this->contentSettings, $this->authCheck, $this->content),
            'pagination' => new PaginationResource($this)
         ];
    }
}
