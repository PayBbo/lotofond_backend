<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LotShortResource extends JsonResource
{
    protected $contentRules;

    public function contentRules($contentRules = null)
    {
        $this->contentRules = $contentRules;
        return $this;
    }

    public function isAvailable($code)
    {
        $authCheck = auth()->guard('api')->check();
        if ($authCheck) {
            return $this->contentRules[$code];
        }
        return false;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $currentPrice = $this->isAvailable('currentPrice') ? $this->start_price : null;
        $currentPriceRed = $this->currentPriceReduction;
        if ($currentPriceRed && $this->isAvailable('currentPrice')) {
            $currentPrice = (float)$currentPriceRed['price'];
        }


        return [
            'id' => $this->id,
            'trade' => (new TradeResource($this->auction))->contentRules($this->contentRules),
            'lotNumber' => $this->isAvailable('lotNumber') ? $this->number : null,
            'photos' => $this->isAvailable('photos') ? $this->photos : null,
            'categories' => $this->isAvailable('categories') ? $this->categoriesStructure() : null,
            'description' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->description)),
            'currentPrice' => (float)$currentPrice

        ];
    }
}
