<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReestrDebtorMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'date' => $this->publish_date,
            'type' => __('registry_notifications.' . $this->registryNotificationType->title),
            'debtor' => new BidderResource($this->debtor),
            'guid' =>  $this->guid,
            'files' => is_null($this->files) ?  [] : $this->files
        ];
    }
}
