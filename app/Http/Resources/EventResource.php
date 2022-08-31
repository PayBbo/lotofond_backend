<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'date'=>$this->date,
            'time'=>$this->time,
            'title'=>$this->title,
            'type'=>$this->event_type,
            $this->mergeWhen(!is_null($this->notification_id), [
                'dataFavourite' => [
                    'favouritePaths' => is_null($this->notification_id) ? null : $this->notification->lot->lot->getLotFavouritePaths(),
                    'lotId'=>is_null($this->notification_id) ? null : $this->notification->lot->lot->id
                ]
            ])
        ];
    }
}
