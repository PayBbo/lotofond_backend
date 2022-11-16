<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Auction;
use App\Models\Status;

class ApplicationSession extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        $type = null;
        switch($this->type){
            case 'BiddingEnd':
            {
                $type = 'finished';
                break;
            }
            case 'BiddingStart':
            {
                $type = 'biddingInProcess';
                break;
            }
            case 'ApplicationSessionEnd':
            {
                $type = 'applicationSessionEnd';
                break;
            }
            case 'ApplicationSessionStart':
            {
                $type = 'applicationSessionStarted';
                break;
            }
        }
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                if (array_key_exists($prefix . 'LotList', $invitation) && array_key_exists($prefix . 'LotInfo', $invitation[$prefix . 'LotList'])) {
                    if (count($invitation[$prefix . 'LotList'][$prefix . 'LotInfo']) > 1) {
                        foreach ($invitation[$prefix . 'LotList'][$prefix . 'LotInfo'] as $lot) {
                            $auction_lot = $auction->lots->where('number', $lot['@attributes']['LotNumber'])->first();
                            if ($auction_lot) {
                                $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'], $auction_lot->status_id, 'status_id');
                                $auction_lot->status_id = Status::where('code', $type)->first()['id'];
                                $auction_lot->save();
                            }
                        }
                    } else {
                        $auction_lot = $auction->lots->where('number', $invitation[$prefix . 'LotList'][$prefix . 'LotInfo']['@attributes']['LotNumber'])->first();
                        if ($auction_lot) {
                            $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'],  $auction_lot->status_id, 'status_id');
                            $auction_lot->status_id = Status::where('code', $type)->first()['id'];
                            $auction_lot->save();
                        }
                    }
                } else {
                    foreach ($auction->lots as $lot) {
                        $this->createNotification($lot->id, $invitation['@attributes']['EventTime'],   $lot->status_id, 'status_id');
                        $lot->status_id = Status::where('code', $type)->first()['id'];
                        $lot->save();
                    }
                }
            }
        } catch (\Exception $e) {
            logger('parseTradeStatusExc: ' . $e);
            logger($invitation);
        }

    }
}
