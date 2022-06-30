<?php

namespace App\Http\Services\Parse;

use App\Models\Category;
use App\Models\Lot;
use App\Models\LotFile;
use App\Models\Param;
use App\Models\PriceReduction;
use Exception;

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
        $lot->status_id = 1;

        if (array_key_exists($prefix . 'Participants', $value) ) {
            if(gettype($value[$prefix . 'Participants']) == 'array'){
                $lot->payment_info = $value[$prefix . 'Participants'][$prefix . 'PaymentInfo'];
                $lot->sale_agreement = $value[$prefix . 'Participants'][$prefix . 'SaleAgreement'];
            }else{
                $lot->participants = $value[$prefix . 'Participants'];
                if(array_key_exists($prefix . 'SaleAgreement', $value)){
                    $lot->sale_agreement = $value[$prefix . 'SaleAgreement'];
                }
                if(array_key_exists($prefix . 'PaymentInfo', $value)){
                    $lot->payment_info = $value[$prefix . 'PaymentInfo'];
                }
            }

        }

        $lot->save();

        if (array_key_exists($prefix . 'TradeObjectHtml', $value)) {
            $lot->description = $value[$prefix . 'TradeObjectHtml'];
            $cadastr_number = '/\d{2}:\d{2}:\d{1,7}:\d{1,}/';
            preg_match_all($cadastr_number, $value[$prefix . 'TradeObjectHtml'], $matches);
            if (count($matches[0]) > 0) {
                $lot->is_parse_ecp = true;
                $lot->params()->attach(Param::find(4), ['value' => $matches[0][0]]);
            }
            $avto_number = '/[АВЕКМНОРСТУХ]\d{3}(?<!000)[АВЕКМНОРСТУХ]{2}\d{2,3}/ui';
            preg_match_all($avto_number, $value[$prefix . 'TradeObjectHtml'], $matches);
            if (count($matches[0]) > 0) {
                $lot->params()->attach(Param::find(5), ['value' => $matches[0][0]]);
            }
            $avto_vin = '/[A-HJ-NPR-Z0-9]{17}/ui';
            preg_match_all($avto_vin, $value[$prefix . 'TradeObjectHtml'], $matches);
            if (count($matches[0]) > 0) {
                $lot->params()->attach(Param::find(6), ['value' => $matches[0][0]]);
            }
        }
        $lot->save();

        if (array_key_exists($prefix . 'PriceReduction', $value)) {
            $this->getPriceReduction($value[$prefix . 'PriceReduction'], $lot->id);
        }else{
            $this->savePriceReduction($lot->id, $lot->start_price, $lot->auction->event_start_date, $lot->auction->event_end_date, null, 0, 0, true);
        }

        if (!is_null($this->files)) {
            foreach ($this->files as $file) {
                $this->saveFiles($file, 'file');
            }
        }

        if (!is_null($this->images)) {
            foreach ($this->images as $image) {
                $this->saveFiles($image, 'image');
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

    public function saveFiles($file, $type)
    {
        $lot = $this->lot;
        if (!LotFile::where(['url' => $file, 'lot_id' => $lot->id, 'type' => $type])->exists()) {
            LotFile::create([
                'url' => $file,
                'type' => $type,
                'lot_id' => $lot->id
            ]);
        }
    }

    public function getPriceReduction($red, $lot_id)
    {
        try {
            $lot = Lot::find($lot_id);
            if (str_starts_with($red, '<table><tr><td><b>')) {
                $pattern = '/<tr[\s\S]*?<\/tr>/';
                preg_match_all($pattern, $red, $matches);
                if (count($matches[0]) > 0) {
                    unset($matches[0][0]);
                    foreach ($matches[0] as $match) {
                        $new_pattern = '/<td[\s\S]*?<\/td>/';
                        preg_match_all($new_pattern, $match, $items);
                        $start_time = substr($items[0][0], 4, strlen($items[0][0]) - 9);
                        $end_time = substr($items[0][3], 4, strlen($items[0][3]) - 9);
                        $price = array_key_exists('6', $items[0]) ? number_format((float)preg_replace("/[^,.0-9]/", '',
                            str_replace(',', '.',
                                substr($items[0][6], 4, strlen($items[0][6]) - 9)
                            )), 2, '.', '') : 0;
                        $percent = array_key_exists('4', $items[0]) ? number_format((float)preg_replace("/[^,.0-9]/", '',
                            str_replace(',', '.',
                                substr($items[0][4], 4, strlen($items[0][5]) - 9)
                            )), 2, '.', '') : 0;
                        $deposit = array_key_exists('5', $items[0]) ? number_format((float)preg_replace("/[^,.0-9]/", '',
                            str_replace(',', '.',
                                substr($items[0][5], 4, strlen($items[0][5]) - 9)
                            )), 2, '.', '') : null;
                        if (date('Y-m-d H:i:s', strtotime($start_time) == $start_time) && $price > 0
                            && date('Y-m-d H:i:s', strtotime($end_time) == $end_time)) {
                            $this->savePriceReduction($lot_id, $price, $start_time, $end_time, null, $percent, $deposit);
                        }
                    }
                }
            }elseif (str_starts_with($red, '<table><thead><tr><td>')){
                $pattern = '/<tr[\s\S]*?<\/tr>/';
                preg_match_all($pattern, $red, $matches);
                if (count($matches[0]) > 0) {
                    unset($matches[0][0]);
                    $i = 0;
                    foreach ($matches[0] as $match) {
                        $new_pattern = '/<td[\s\S]*?<\/td>/';
                        preg_match_all($new_pattern, $match, $items);
                        $start_time = substr($items[0][3], 4, strlen($items[0][3]) - 9);
                        $end_time = substr($items[0][4], 4, strlen($items[0][4]) - 9);
                        $price =  number_format((float)preg_replace("/[^,.0-9]/", '',
                            str_replace(',', '.',
                                substr($items[0][1], 4, strlen($items[0][1]) - 9)
                            )), 2, '.', '');
                        $deposit =  number_format((float)preg_replace("/[^,.0-9]/", '',
                            str_replace(',', '.',
                                substr($items[0][2], 4, strlen($items[0][2]) - 9)
                            )), 2, '.', '');
                        if($i>0){
                            $prev_item = explode(': ',$matches[0][$i-1]);
                            $prev_price = (float)$prev_item[1];
                        }else{
                            $prev_price = $lot->start_price;
                        }
                        if (date('Y-m-d H:i:s', strtotime($start_time) == $start_time) && $price > 0
                            && date('Y-m-d H:i:s', strtotime($end_time) == $end_time)) {
                            $this->savePriceReduction($lot_id, $price, $start_time, $end_time, $prev_price, 0, $deposit);
                        }
                        $i++;
                    }
                }
            } else {
                $values = explode('<br/>', $red);
                $i=0;
                foreach ($values as $value) {
                    $items = explode(': ', $value);
                    if (count($items) > 1) {
                        $price = (float)$items[1];
                        if (date('Y-m-d H:i:s', strtotime($items[0]) == $items[0]) && $price!=0) {
                            if($i<count($values)) {
                                $next_item = explode(': ',$values[$i+1]);
                                $time_end = $next_item[0];
                            }else{
                                $time_end = $lot->auction->result_date;
                            }
                            if($i>0){
                                $prev_item = explode(': ',$values[$i-1]);
                                $prev_price = (float)$prev_item[1];
                            }else{
                                $prev_price = $lot->start_price;
                            }
                          $this->savePriceReduction($lot_id, $price, $items[0], $time_end, $prev_price);
                        }
                    }
                    $i++;
                }
            }
        } catch (Exception $e) {
            logger('e: ' . $e);
        }
    }

    public function savePriceReduction($lot_id, $price, $start_time, $end_time, $prev_price=null, $percent=0, $deposit=0, $is_system=false)
    {
        if(!is_null($prev_price)) {
            if ($prev_price > $price) {
                $percent = ((float)$prev_price / (float)$price - 1) * 100;
            }
        }
        PriceReduction::create([
            'lot_id' => $lot_id,
            'price' => $price,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'percent' => $percent,
            'deposit'=>$deposit,
            'is_system'=>$is_system
        ]);
    }

}
