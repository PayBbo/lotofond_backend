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
        $value = !is_null($this->value) ? __('messages.' . $this->message, ['value' => $this->value]) :
            __('messages.' . $this->message);
        return [
            'id' => $this->id,
            'isSeen' => $this->is_seen,
            'type' => $this->type->title,
            'date' => $this->date,
            $this->mergeWhen($this->type_id == 1, [
                'dataPlatform' => [
                    'label' => __('messages.' . $this->label),
                    'value' => $value,
                    'action' => $this->platform_action
                ]
            ]),
            $this->mergeWhen($this->type_id == 2, [
                'dataFavourite' => [
                    'photos' => is_null($this->lot_id) ? null : $this->lot->lot->photos,
                    'description' => is_null($this->lot_id) ? null : stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->lot->lot->description)),
                    'detail' => $value,
                    'favouritePaths' => is_null($this->lot_id) ? null : $this->lot->lot->getLotFavouritePaths(),
                    'id'=>is_null($this->lot_id) ? null : $this->lot->lot->id,
                    'categories'=>is_null($this->lot_id) ? [] : $this->lot->lot->categoriesStructure(),
                ]
            ]),
            $this->mergeWhen($this->type_id  == 3, [
                'dataMonitoring' => [
                    'folderInfo' =>
                        [
                            'name' =>  is_null($this->monitoring_id) ? null : $this->monitoring->title,
                            'pathId' =>  is_null($this->monitoring_id) ? null : $this->monitoring_id,
                            'color' =>  is_null($this->monitoring_id) ? null : $this->monitoring->color
                        ],
                    'newLotCount' => (integer)$this->value
                ]

            ])
        ];
    }
}
