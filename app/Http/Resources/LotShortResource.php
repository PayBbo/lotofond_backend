<?php

namespace App\Http\Resources;

use App\Http\Services\ContentSettingsService;
use Illuminate\Http\Resources\Json\JsonResource;

class LotShortResource extends JsonResource
{
    protected $contentSettings;

    public function contentRules($settings)
    {
        $this->contentSettings = $settings;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $currentPrice =  $this->contentSettings->isAvailable('currentPrice') ? $this->start_price : null;
        $currentPriceRed = $this->currentPriceReduction;
        if ($currentPriceRed &&  $this->contentSettings->isAvailable('currentPrice')) {
            $currentPrice = (float)$currentPriceRed['price'];
        }


        return [
            'id' => $this->id,
            'trade' => (new TradeResource($this->auction))->content($this->contentSettings),
            'lotNumber' =>  $this->contentSettings->isAvailable('lotNumber') ? $this->number : null,
            'photos' =>  $this->contentSettings->isAvailable('photos') ? $this->photos : null,
            'categories' =>  $this->contentSettings->isAvailable('categories') ? $this->categoriesStructure() : null,
            'description' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->description)),
            'currentPrice' => (float)$currentPrice

        ];
    }
}
