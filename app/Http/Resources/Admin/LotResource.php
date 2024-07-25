<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\FavouritePathResource;
use App\Http\Resources\TradeResource;
use App\Traits\PriceTrait;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class LotResource extends JsonResource
{
    use PriceTrait;
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $lotData = [
            'id' => $this->id,
            'additionalLotInfoIsModerated' => is_null($this->additional_lot_info_is_moderated) ? null : !!$this->additional_lot_info_is_moderated,
            'additionalLotInfoId' => $this->additional_lot_info_id ?: ($this->additionalLotInfo ? $this->additionalLotInfo->id : null),
            'tradeNumber' => isset($this->auction) ? $this->auction->trade_id : $this->trade_number,
            'tradeType' => isset($this->auction) ? $this->auction->auctionType->title : $this->trade_type,
            'description' => $this->description,
            'startPrice' => $this->start_price,
            'status' => isset($this->status) ? $this->status->value : $this->status_value,
            'publishDate'=> isset($this->auction)
                ? (is_null($this->auction->publish_date) ? null : $this->auction->publish_date->format('d.m.Y H:i'))
                : $this->publish_date
        ];
        if($this->isLotInfo){
            $regions = $this->showRegions;
            $priceReductions = $this->showPriceReductions->makeHidden('lot_id');
            $currentPrice = $this->start_price;
            $currentPriceState = 'hold';
            $currentPriceRed = $this->currentPriceReduction;
            foreach ($priceReductions as $priceReduction) {
                $priceReduction->isCurrentStage = false;
                if ($currentPriceRed) {
                    if ($priceReduction->id == $currentPriceRed['id']) {
                        $priceReduction->isCurrentStage = true;
                    }
                }
            }
            if ($currentPriceRed) {
                $currentPrice = (float)$currentPriceRed['price'];
            }
            $lotData['eventTimeStart'] = is_null($this->auction->event_start_date) ? null : $this->auction->event_start_date->format('d.m.Y H:i');
            $lotData['eventTimeEnd'] = is_null($this->auction->event_end_date) ? null : $this->auction->event_end_date->format('d.m.Y H:i');
            $lotData['eventTimeResult'] =  is_null($this->auction->result_date) ? null : $this->auction->result_date->format('d.m.Y H:i');
            $lotData['applicationTimeStart'] = is_null($this->auction->application_start_date) ? null : $this->auction->application_start_date->format('d.m.Y H:i');
            $lotData['applicationTimeEnd'] = is_null($this->auction->publish_date) ? null : $this->auction->application_end_date->format('d.m.Y H:i');
            $lotData['lotNumber'] = $this->number;
            $lotData['images'] = $this->lotFiles()->where('type', 'image')->where('additional_lot_info_id' , null)->where('user_id', null)->select('id', 'url', 'url as name')->get();

            $lotData['files'] = $this->lotFiles()->where('type', 'file')->where('additional_lot_info_id' , null)->select('id', 'url', 'url as name')->get();
            $lotData['categories'] = $this->categoriesStructure();
            $lotData['location'] =  $regions->makeHidden(['pivot']);
            $lotData['priceReduction'] = $this->price_reduction;
            $lotData['currentPrice'] = $currentPrice;
            $lotData['minPrice'] = (float)$this->min_price;
            $lotData['link'] = URL::to('/lot/' . $this->id);

            $lotData['efrsbLink'] = 'https://fedresurs.ru/bidding/' . $this->auction->guid;
            $descriptionExtracts = $this->description_extracts;
            if ($descriptionExtracts && count($descriptionExtracts)) {
////                $extracts = $descriptionExtracts[0]['extracts'];
////                $obj = array_column($extracts, null, 'type')['cadastralDataPrice'] ?: false;
//                $extract = array_reduce($descriptionExtracts, static function ($carry, $item) {
//                    $ext = (array_column($item['extracts'], null, 'type')['cadastralDataPrice'] ?: false);
//                    return $carry === false && $ext ? $ext : $carry;
//                }, false);
//                if ($extract) {
//                    $price = +$extract['value'];
//                    $lotData['tax'] = 'от ' . $this->priceFormat(round($price * 0.3 / 100, 2)) . ' до '
//                        . $this->priceFormat(round($price * 2 / 100, 2));
////                    $lotData['descriptionExtracts']['extracts'][] = [
////                        'title' => 'Налог',
////                        'type' => 'tax',
////                        'value' => 'от ' . $this->priceFormat(round($price * 0.3 / 100, 2)) . ' до ' . $this->priceFormat(round($price * 2 / 100, 2)) . ' ₽'
////                    ];
//                }
                foreach ($descriptionExtracts as $index => $item) {
                    $cad = array_column($item['extracts'], null, 'type');
                    $ext = ($cad && isset($cad['cadastralDataPrice']) ? $cad['cadastralDataPrice'] : false);
                    if($ext) {
                        $price = +$ext['value'];
                        $descriptionExtracts[$index]['extracts'][] = [
                            'title' => 'Налог',
                            'type' => 'other',
                            'value' => 'от ' . $this->priceFormat(round($price * 0.3 / 100, 2)) . ' до '
                                . $this->priceFormat(round($price * 2 / 100, 2)) . ' ₽'
                        ];
                    }
                }
            }
            $lotData['descriptionExtracts'] = $descriptionExtracts;
            $lotData['stepPrice'] = null;
            if(!is_null($this->auction_step)){
                $lotData['stepPrice'] = [
                    'type' => $this->is_step_rub ? 'rubles' : 'percent',
                    'value' => $this->auction_step
                ];
            }
            $lotData['deposit'] = null;
            if(!is_null($this->deposit)){
                $lotData['deposit'] = [
                    'type' => $this->is_deposit_rub ? 'rubles' : 'percent',
                    'value' => $this->deposit
                ];
            }
        }
        return $lotData;
    }
}
