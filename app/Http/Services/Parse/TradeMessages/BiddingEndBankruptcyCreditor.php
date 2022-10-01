<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Auction;
use App\Models\Status;

class BiddingEndBankruptcyCreditor extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                if (array_key_exists($prefix . 'CreditorLotNumberList', $invitation)) {
                    $lotList = $invitation[$prefix . 'CreditorLotNumberList'][$prefix . 'CreditorLotNumber'];
                    if (count($lotList) > 1) {
                        foreach ($lotList as $lot) {
                            $this->changeStatus($auction, $lot, $invitation);
                        }
                    } else {
                        $this->changeStatus($auction, $lotList, $invitation);
                    }
                } else {
                    foreach ($auction->lots as $lot) {
                        $this->changeStatus($auction, $lot, $invitation);
                    }
                }
            }
        } catch (\Exception $e) {
            logger('BiddingEndBankruptcyCreditorExc: ' . $e);
            logger($invitation);
        }

    }

    public function changeStatus($auction, $lot, $invitation){
        $auction_lot = $auction->lots->where('number', $lot['@attributes']['LotNumber'])->first();
        if ($auction_lot) {
            $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'], $auction_lot->status_id, 'status_id');
            $auction_lot->status_id = Status::where('code', 'finished')->first()['id'];
            $auction_lot->save();
        }
    }
}
