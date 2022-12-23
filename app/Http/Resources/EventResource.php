<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    protected $contentSettings;

    public function content($settings)
    {
        $this->contentSettings = $settings;
        return $this;
    }
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
            $this->mergeWhen(!is_null($this->favourite_lot_id), [
                'dataFavourite' => [
                    'favouritePaths' => is_null($this->favourite_lot_id) ? null : $this->favouriteLot->lot->getLotFavouritePaths(),
                    'lotId'=>is_null($this->favourite_lot_id) ? null : $this->favouriteLot->lot->id,
                    'photos' => is_null($this->favourite_lot_id) ? null : $this->favouriteLot->lot->photos,
                    'description' => is_null($this->favourite_lot_id) ? null : ($this->contentSettings->isAvailable('descriptionExtracts') ? $this->favouriteLot->lot->description : $this->favouriteLot->lot->processed_description),
                    'categories'=>is_null($this->favourite_lot_id) ? [] : $this->favouriteLot->lot->categoriesStructure(),
                ]
            ])
        ];
    }
}
