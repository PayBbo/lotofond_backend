<?php

namespace App\Http\Services\Parse;

use App\Models\Lot;
use App\Models\PriceReduction;
use App\Models\TradeMessage;
use Carbon\Carbon;
use Exception;

class PriceReductionService
{

    public function getPriceReduction($red, $lot_id)
    {
        try {
            $lot = Lot::find($lot_id);
            if (str_starts_with($red, '&lt;table&gt;&lt;')) {
                $red = htmlspecialchars_decode($red);
            }
            if (str_starts_with($red, '<table><tr><td><b>')) {
                $pattern = '/<tr[\s\S]*?<\/tr>/';
                preg_match_all($pattern, $red, $matches);
                if (count($matches[0]) > 0) {
                    unset($matches[0][0]);
                    $this->getPriceReductionParams($matches, 0, 3, 6, $lot, 5);
                }
            } elseif (str_starts_with($red, '<table><thead><tr><td>')) {
                $pattern = '/<tr[\s\S]*?<\/tr>/';
                preg_match_all($pattern, $red, $matches);
                if (count($matches[0]) > 0) {
                    unset($matches[0][0]);
                    $this->getPriceReductionParams($matches, 3, 4, 1, $lot, 2);
                }
            } elseif (str_starts_with($red, '<table><thead><tr><th>')) {
                $pattern = '/<tr[\s\S]*?<\/tr>/';
                preg_match_all($pattern, $red, $matches);
                if (count($matches[0]) > 0) {
                    unset($matches[0][0]);
                    $this->getPriceReductionParams($matches, 0, 3, 5, $lot, 4);
                } elseif (str_starts_with($red, '<table><tr><td>')) {
                    $pattern = '/<tr[\s\S]*?<\/tr>/';
                    preg_match_all($pattern, $red, $matches);
                    if (count($matches[0]) > 0) {
                        $this->getPriceReductionParams($matches, 0, 1, 2, $lot);
                    }
                } else {
                    try {
                        $values = explode('<br/>', $red);
                        $i = 1;
                        foreach ($values as $value) {
                            $items = explode(': ', $value);
                            if (count($items) > 1) {
                                $price = (float)$items[1];
                                if (date('Y-m-d H:i:s', strtotime($items[0]) == $items[0]) && $price != 0) {
                                    if ($i < count($values) - 1) {
                                        $next_item = explode(': ', $values[$i + 1]);
                                        $time_end = $next_item[0];
                                    } else {
                                        $time_end = $lot->auction->result_date;
                                    }
                                    if ($i > 1) {
                                        $prev_item = explode(': ', $values[$i - 1]);
                                        $prev_price = (float)$prev_item[1];
                                    } else {
                                        $prev_price = $lot->start_price;
                                    }
                                    $this->savePriceReduction($lot_id, $price, $items[0], $time_end, $prev_price);
                                }
                            }
                            $i++;
                        }
                    } catch (Exception $e) {
                    }
                }
                if (PriceReduction::where('lot_id', $lot->id)->count() == 0) {
                    $this->savePriceReduction($lot->id, $lot->start_price, $lot->auction->event_start_date, $lot->auction->event_end_date, null, 0, 0, true);
                }
            } elseif (str_starts_with($red, '<table><tr><td>')) {
                $pattern = '/<tr[\s\S]*?<\/tr>/';
                preg_match_all($pattern, $red, $matches);
                if (count($matches[0]) > 0) {
                    $this->getPriceReductionParams($matches, 0, 1, 2, $lot);
                }
            }
        } catch
        (Exception $e) {
            logger('e: ' . $e);
            logger($red);
        }
    }

    public function getPriceReductionParams($matches, $start_time_index, $end_time_index, $price_index, $lot, $deposit_index = null)
    {
        $i = 0;
        foreach ($matches[0] as $match) {
            $new_pattern = '/<td[\s\S]*?<\/td>/';
            preg_match_all($new_pattern, $match, $items);
            $start_time = substr($items[0][$start_time_index], 4, strlen($items[0][$start_time_index]) - 9);
            $end_time = substr($items[0][$end_time_index], 4, strlen($items[0][$end_time_index]) - 9);
            $price = array_key_exists((string)$price_index, $items[0]) ? number_format((float)preg_replace("/[^,.0-9]/", '',
                str_replace(',', '.',
                    substr($items[0][$price_index], 4, strlen($items[0][$price_index]) - 9)
                )), 2, '.', '') : 0;
            $deposit = null;
            if (!is_null($deposit_index)) {
                $deposit = array_key_exists((string)$deposit_index, $items[0]) ? number_format((float)preg_replace("/[^,.0-9]/", '',
                    str_replace(',', '.',
                        substr($items[0][$deposit_index], 4, strlen($items[0][$deposit_index]) - 9)
                    )), 2, '.', '') : null;
            }
            if ($i > 1) {
                preg_match_all($new_pattern, $matches[0][$i - 1], $prev_item);
                $prev_price = array_key_exists((string)$price_index, $items[0]) ? (float)preg_replace("/[^,.0-9]/", '',
                    str_replace(',', '.',
                        substr($prev_item[0][$price_index], 4, strlen($prev_item[0][$price_index]) - 9))) : 0;
            } else {
                $prev_price = $lot->start_price;
            }
            if (date('Y-m-d H:i:s', strtotime($start_time) == $start_time) && $price > 0
                && date('Y-m-d H:i:s', strtotime($end_time) == $end_time)) {
                $this->savePriceReduction($lot->id, $price, $start_time, $end_time, $prev_price, 0, $deposit);
            }
            $i++;
        }
    }

    public function savePriceReduction($lot_id, $price, $start_time, $end_time, $prev_price = null, $percent = 0, $deposit = 0, $is_system = false)
    {
        if (!is_null($prev_price)) {
            $percent = ((float)$prev_price - (float)$price) / (float)$prev_price * 100;
        }
        if (!is_null($price)) {
            PriceReduction::create([
                'lot_id' => $lot_id,
                'price' => $price,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'percent' => $percent,
                'deposit' => $deposit,
                'is_system' => $is_system
            ]);
        }
    }

    public function saveFinalPrice($biddingResult)
    {
        $tradeMessage = \App\Models\TradeMessage::find($biddingResult->trade_message_id);
        $lot = $tradeMessage->lot;
        $currentPriceRed = $lot->currentPriceReduction;
        if ($currentPriceRed) {
            $old_price = $currentPriceRed->price;
            $currentPriceRed->price = $biddingResult->end_price;
            $currentPriceRed->save();
        } else {
            $old_price = $lot->start_price;
            $currentPriceRed = \App\Models\PriceReduction::create([
                'lot_id' => $lot->id,
                'start_time' => Carbon::now()->setTimezone('Europe/Moscow'),
                'end_time' => null,
                'price' => $biddingResult->end_price,
                'percent' => ((float)$old_price / (float)$biddingResult->end_price - 1) * 100,
                'is_system' => true
            ]);
        }

        $param = ['price' => $old_price, 'id' => $currentPriceRed->id, 'new_id' => null];
        if (!is_null($tradeMessage->param)) {
            $param[$tradeMessage->param_type] = $tradeMessage->param;
        }
        $tradeMessage->param = json_encode($param);
        $tradeMessage->param_type = 'current_price';
        $tradeMessage->save();
        logger($biddingResult->id);
        logger('---------------------------');

    }


}
