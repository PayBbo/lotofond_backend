<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $value = is_null($this->value) ? __('messages.' . $this->message, ['value' => $this->value]) :
            __('messages.' . $this->message);
        return [
            'id' => $this->id,
            'value' => $value,
            'date' => $this->date,
            $this->mergeWhen(!is_null($this->lot_id), [
                'lot' => [
                    'photos' => is_null($this->lot_id) ? null : $this->lot->photos,
                    'description' => is_null($this->lot_id) ? null : stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->lot->description))
                ],
            ]),
            'isSeen' => $this->is_seen,
            $this->mergeWhen($this->type_id == 1, [
                'label' => __('messages.' . $this->label),
                'actionType' => $this->platform_action
            ])
        ];
    }
}
