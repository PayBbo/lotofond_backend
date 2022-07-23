<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        $userEstimate = $this->getUserEstimate($this->role);
        return [
            'estimate'=> is_null($userEstimate) ? 0 : $userEstimate->estimate,
            'comment'=> is_null($userEstimate) ? null : $userEstimate->comment,
            'rating'=>$this->rating($this->role)
        ];
    }
}
