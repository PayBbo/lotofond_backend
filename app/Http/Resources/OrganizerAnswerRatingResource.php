<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizerAnswerRatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userEstimate = $this->getUserEstimate();
        return [
            'estimate'=> is_null($userEstimate) ? 0 : $userEstimate->estimate,
            'comment'=> is_null($userEstimate) ? null : $userEstimate->comment,
            'rating'=>$this->rating()
        ];
    }
}
