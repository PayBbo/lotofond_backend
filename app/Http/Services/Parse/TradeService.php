<?php

namespace App\Http\Services\Parse;

use App\Models\Category;
use App\Models\Lot;
use App\Models\LotFile;
use App\Models\Status;

class TradeService
{
    protected $value;
    protected $prefix;
    protected $files;
    protected $images;
    protected $lot;

    public function __construct($auction, $value, $prefix, $files = null, $images = null)
    {
        if ($auction->lots->where('number', $value['@attributes']['LotNumber'])->count() == 0) {
            $lot = new Lot();
            $lot->auction_id = $auction->id;
        } else {
            $lot = $auction->lots->where('number', $value['@attributes']['LotNumber'])->first();
        }
        $this->lot = $lot;
        $this->value = $value;
        $this->prefix = $prefix;
        $this->files = $files;
        $this->images = $images;
    }


    public function saveLot()
    {
        $lot = $this->lot;
        $prefix = $this->prefix;
        $value = $this->value;

        $lot->number = $value['@attributes']['LotNumber'];
        $lot->start_price = array_key_exists($prefix . 'StartPrice', $value) ? $value[$prefix . 'StartPrice'] : 0;
        if (array_key_exists($prefix . 'TradeObjectHtml', $value)) {
            $lot->description = $value[$prefix . 'TradeObjectHtml'];
            $pattern = '/\d{2}:\d{2}:\d{1,7}:\d{1,}/';
            preg_match_all($pattern, $value[$prefix . 'TradeObjectHtml'], $matches);
            if(count($matches[0])>0){
                $lot->cadastral_number = $matches[0][0];
            }
        }
        if (array_key_exists($prefix . 'PriceReduction', $value)) {
            $lot->price_reduction = $this->getPriceReduction($value[$prefix . 'PriceReduction']);
        }
        if (array_key_exists($prefix . 'AdvancePercent', $value)) {
            $lot->deposit = gettype($value[$prefix . 'AdvancePercent']) == 'array' ? NULL : $value[$prefix . 'AdvancePercent'];
            $lot->is_deposit_rub = false;
        } elseif (array_key_exists('Advance', $value)) {
            $lot->deposit = gettype($value['Advance']) == 'array' ? NULL : $value['Advance'];
        }
        if (array_key_exists($prefix . 'StepPricePercent', $value)) {
            $lot->auction_step = gettype($value[$prefix . 'StepPricePercent']) == 'array' ? NULL : $value[$prefix . 'StepPricePercent'];
            $lot->is_step_rub = false;
        } elseif (array_key_exists($prefix . 'StepPrice', $value)) {
            $lot->auction_step = gettype($value[$prefix . 'StepPrice']) == 'array' ? NULL : $value[$prefix . 'StepPrice'];
        }
        $lot->status_id = Status::where('code', 'BiddingInvitation')->first()['id'];

        if (!is_null($this->images)) {
           $lot->images = $this->images;
        }
        if(array_key_exists($prefix . 'Concours', $value)) {
            $lot->concours = $value[$prefix . 'Concours'];
        }
        if(array_key_exists($prefix . 'Participants', $value)) {
            $lot->participants = $value[$prefix . 'Participants'];
        }
        $lot->payment_info = $value[$prefix . 'PaymentInfo'];
        $lot->sale_agreement = $value[$prefix . 'SaleAgreement'];

        $lot->save();

        if (!is_null($this->files)) {
            foreach($this->files as $file){
                $this->saveFiles($file);
            }
        }
        if (gettype($value[$prefix . 'Classification'][$prefix . 'IDClass']) == 'array') {
            foreach ($value[$prefix . 'Classification'][$prefix . 'IDClass'] as $item) {
                $category = Category::where('code', $item)->first();
                if (!$lot->categories->contains($category)) {
                    $lot->categories()->attach($category);
                }
            }
        } else {
            $category = Category::where('code', $value[$prefix . 'Classification'][$prefix . 'IDClass'])->first();
            if (!$lot->categories->contains($category)) {
                $lot->categories()->attach($category);
            }
        }
        return $lot;

    }

    public function saveFiles($file){
        $lot = $this->lot;
        if(!LotFile::where(['url'=>$file, 'lot_id'=>$lot->id, 'type'=>'file'])->exists()){
            LotFile::create([
                'url'=>$file,
                'type'=>'file',
                'lot_id'=>$lot->id
            ]);
        }
    }

    public function getPriceReduction($red){
        $result = [];
        $pattern = '/<tr[\s\S]*?<\/tr>/';
        preg_match_all($pattern, $red, $matches);
        if(count($matches[0])>0) {
            unset($matches[0][0]);
            foreach ($matches[0] as $match) {
                $new_pattern = '/<td[\s\S]*?<\/td>/';
                preg_match_all($new_pattern, $match, $items);
                $result[] = [
                    'time' => substr($items[0][0], 4, strlen($items[0][0]) - 9),
                    'price' => array_key_exists('6', $items[0]) ? number_format((float)preg_replace("/[^,.0-9]/", '',
                        str_replace(',', '.',
                            substr($items[0][6], 4, strlen($items[0][6]) - 9)
                        )), 2, '.', '') : null,
                    'deposit' => array_key_exists('5', $items[0]) ? number_format((float)preg_replace("/[^,.0-9]/", '',
                        str_replace(',', '.',
                            substr($items[0][5], 4, strlen($items[0][5]) - 9)
                        )), 2, '.', '') : null,
                ];
            }
        }else{
            $values = explode('<br/>', $red);
            foreach($values as $value){
                $items = explode(': ', $value);
                if(count($items)>1) {
                    $result[] = [
                        'time' => $items[0],
                        'price' => number_format((float)$items[1], 2, '.', ''),
                        'deposit' => null
                    ];
                }
            }
        }
        return $result;
    }

}
