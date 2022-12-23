<?php

namespace App\Http\Resources;

use App\Http\Services\ContentSettingsService;
use App\Models\Notification;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public $collects = 'App\Http\Resources\NotificationResource';

    protected $contentSettings;

    public function __construct($resource)
    {
        $this->contentSettings = new ContentSettingsService();
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collection->each->content($this->contentSettings),
            'pagination' => new PaginationResource($this),
            'platformNotificationsCount'=>Notification::where(['user_id'=>auth()->id(), 'type_id'=>1, 'is_seen'=>false])->count(),
            'favouriteNotificationsCount'=>Notification::where(['user_id'=>auth()->id(), 'type_id'=>2, 'is_seen'=>false])->count(),
            'monitoringNotificationsCount'=>Notification::where(['user_id'=>auth()->id(), 'type_id'=>3, 'is_seen'=>false])->count()
        ];
    }
}
