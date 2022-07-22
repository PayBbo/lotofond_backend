<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class TradePlaceResource extends JsonResource
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
            'name' => $this->name,
            'id' => $this->id,
            $this->mergeWhen($this->isReestr || Route::getCurrentRoute()->getName() === 'trade-places', [
                'site' => str_starts_with($this->site, 'http') ? $this->site : 'http://' . $this->site,
                'ownerName' => $this->owner_name,
                'inn' => $this->inn,
               // 'note' => $this->getNote()
            ])
        ];
    }
}
