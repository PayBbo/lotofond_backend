<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'value'=>__('messages.'.$this->message, ['value'=>$this->value]),
            'date'=>$this->date,
            'lot'=>[
                'photos'=> $this->lot->photos,
                'description'=>stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->lot->description))
            ],
            'isSeen'=>$this->is_seen
        ];
    }
}
