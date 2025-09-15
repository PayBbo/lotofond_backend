<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        $userTariff = null;
        if (auth()->guard('api')->check()) {
            $header = $request->header('TGBot');
            $user = auth()->guard('api')->user();
            if($header) {
                $userTariff = $user->botTariff;
            }
            else {
                $userTariff = $user->tariff;
            }
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'period' => $this->period,
            'price' => $this->price,
            'type' => $this->type,
            'description' => [
                'mainInfo' => $this->description,
                'includedDetails' => $this->included_details,
                'excludedDetails' => $this->excluded_details,
            ],

            'isUserTariff' => !is_null($userTariff) && $userTariff->tariff->id == $this->id,
            'expiredAt' => !is_null($userTariff) && $userTariff->tariff->id == $this->id ? Carbon::parse($userTariff->finished_at)->format('d.m.Y H:i:s') : null

        ];
    }
}
