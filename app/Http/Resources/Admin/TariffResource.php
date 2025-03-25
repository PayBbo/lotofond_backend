<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

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
        $typeNames = [
            'service' => 'Услуга',
            'tariff' => 'Тариф',
            'bot_tariff' => 'Тариф бота',
            'combined_tariff' => 'Тариф сайт+бот'
        ];
        return [
            'id' => $this->id,
            $this->mergeWhen(Route::getCurrentRoute()->getName() === 'admin-get-tariffs', [
                'title' => $this->title,
            ]),
            $this->mergeWhen(Route::getCurrentRoute()->getName() != 'admin-get-tariffs', [
                'title' => $this->getTranslations('title'),
            ]),
            'period' => $this->period,
            'price' => $this->price,
            $this->mergeWhen(Route::getCurrentRoute()->getName() === 'admin-get-tariffs', [
                'description' => $this->description,
            ]),
            $this->mergeWhen(Route::getCurrentRoute()->getName() != 'admin-get-tariffs', [
                'description' => $this->getTranslations('description'),
            ]),
            'type'=> $this->type,
            'type_name'=> $typeNames[$this->type],
            'includedDetails' => $this->getTranslations('included_details'),
            'excludedDetails' => $this->getTranslations('excluded_details'),
            'active' => $this->active
        ];
    }
}
