<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Auction;
use App\Models\PriceReduction;

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
                    $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'],  $auction_lot->start_price, 'start_price');
                    $auction_lot->start_price = $price;
                    $auction_lot->save();
                    $priceReduction = PriceReduction::where(['lot_id' => $auction_lot->id, 'is_system' => true])->first();
                    if($priceReduction) {
                        $priceReduction->price = $price;
                        $priceReduction->save();
                    }
                }
            }
        } catch (\Exception $e) {
            logger('biddingProcessInfo(Exc: ' . $e);
            logger($invitation);
        }
    }
}
