<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Auction;
use App\Models\PriceReduction;
use Carbon\Carbon;

class BiddingProcess extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                $data = $invitation[$prefix . 'PriceInfo']['@attributes'];
                $auction_lot = $auction->lots->where('number', $data['LotNumber'])->first();
                if ($auction_lot) {
                    $price = $data['NewPrice'];
                    $priceReduction = $auction_lot->currentPriceReduction->first();
                    $new_id = null;
                    if($priceReduction) {
                        $old_price = $priceReduction->price;
                        if ($priceReduction->is_system && PriceReduction::where('lot_id', $auction_lot->id)->count() == 1) {
                            $priceReduction->end_time = Carbon::now()->setTimezone('Europe/Moscow');
                            $priceReduction->save();
                            $newPriceReduction = PriceReduction::create([
                                'lot_id' => $auction_lot->id,
                                'start_time' => Carbon::now()->setTimezone('Europe/Moscow'),
                                'end_time' => null,
                                'price' => $price,
                                'percent' => ((float)$priceReduction->price / (float)$price - 1) * 100,
                                'is_system'=>true
                            ]);
                            $new_id = $newPriceReduction->id;
                        } else {
                            $priceReduction->price = $price;
                            $priceReduction->save();
                        }
                    }else{
                        $old_price = $auction_lot->start_price;
                        $priceReduction = PriceReduction::create([
                            'lot_id' => $auction_lot->id,
                            'start_time' => $auction_lot->created_at,
                            'end_time' => Carbon::now()->setTimezone('Europe/Moscow'),
                            'price' => $auction_lot->start_price,
                            'percent' => 0,
                            'is_system'=>true
                        ]);
                        $newPriceReduction = PriceReduction::create([
                            'lot_id' => $auction_lot->id,
                            'start_time' => Carbon::now()->setTimezone('Europe/Moscow'),
                            'end_time' => null,
                            'price' => $price,
                            'percent' => ((float)$auction_lot->start_price / (float)$price - 1) * 100,
                            'is_system'=>true
                        ]);
                        $new_id = $newPriceReduction->id;
                    }
                    $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'],
                        json_encode(['price'=>$old_price, 'id'=>$priceReduction->id, 'new_id'=>$new_id]),
                        'current_price');

                }
            }
        } catch (\Exception $e) {
            logger('biddingProcessInfo(Exc: ' . $e);
            logger($invitation);
        }
    }
}
