<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TariffResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'period' => $this->period,
            'price' => $this->price,
            'isUserTariff' => auth()->guard('api')->check() && auth()->guard('api')->user()->tariff && auth()->guard('api')->user()->tariff->id == $this->id
        ];
    }
}
