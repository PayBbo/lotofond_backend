<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Auction;
use App\Models\Status;

class BiddingStatusInfo extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        $type = null;
        switch ($this->type) {
            case 'BiddingCancel':
            {
                $type = 'biddingCanceled';
                break;
            }
            case 'BiddingFail':
            {
                $type = 'biddingFail';
                break;
            }
            case  'BiddingPause':
            {
                $type = 'biddingPaused';
                break;
            }
        }
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                if (array_key_exists($prefix . 'LotList', $invitation) && array_key_exists($prefix . 'BiddingStateLotInfo', $invitation[$prefix . 'LotList'])) {
                    if (array_key_exists($prefix . 'BiddingStateLotInfo', $invitation[$prefix . 'LotList'])) {
                        if (count($invitation[$prefix . 'LotList'][$prefix . 'BiddingStateLotInfo']) > 1) {
                            foreach ($invitation[$prefix . 'LotList'][$prefix . 'BiddingStateLotInfo'] as $value) {
                                $auction_lot = $auction->lots->where('number', $value['@attributes']['LotNumber'])->first();
                                if ($auction_lot) {
                                    $tradeMessage = $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'],
                                        $auction_lot->status_id, 'status_id',
                                        $value['@attributes']['Reason']);
                                    if (!is_null($type)) {
                                        $auction_lot->status_id = Status::where('code', $type)->first()['id'];
                                    } else {
                                        $lastTradeMessage = \App\Models\TradeMessage::where(['lot_id' => $auction_lot->id, 'param_type' => 'status_id'])->latest()->first();
                                        $auction_lot->status_id = $lastTradeMessage->param;
                                    }
                                    $this->parseFile($prefix, $invitation, $auction, $auction_lot, $tradeMessage);
                                    $auction_lot->save();
                                }
                            }
                        } else {
                            $auction_lot = $auction->lots->where('number', $invitation[$prefix . 'LotList'][$prefix . 'BiddingStateLotInfo']['@attributes']['LotNumber'])->first();
                            if ($auction_lot) {
                                $tradeMessage = $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime'],
                                    $auction_lot->status_id, 'status_id',
                                    $invitation[$prefix . 'LotList'][$prefix . 'BiddingStateLotInfo']['@attributes']['Reason']);
                                if (!is_null($type)) {
                                    $auction_lot->status_id = Status::where('code', $type)->first()['id'];
                                } else {
                                    $lastTradeMessage = \App\Models\TradeMessage::where(['lot_id' => $auction_lot->id, 'param_type' => 'status_id'])->latest()->first();
                                    $auction_lot->status_id = $lastTradeMessage->param;
                                }
                                $this->parseFile($prefix, $invitation, $auction, $auction_lot, $tradeMessage);
                                $auction_lot->save();
                            }
                        }
                    } else {
                        $this->changeAllAuctionLots($auction, $invitation, $prefix, $type);
                    }

                } else {
                    $this->changeAllAuctionLots($auction, $invitation, $prefix, $type);
                }
            }
        } catch (\Exception $e) {
            logger('biddingStatusWithReasonExc: ' . $e);
            logger($invitation);
        }
    }

    public function changeAllAuctionLots($auction, $invitation, $prefix, $type)
    {
        foreach ($auction->lots as $lot) {
            $tradeMessage = $this->createNotification($lot->id, $invitation['@attributes']['EventTime'],
                $lot->status_id, 'status_id',
                $invitation['@attributes']['Reason']);
            $this->parseFile($prefix, $invitation, $auction, $lot, $tradeMessage);
            if (!is_null($type)) {
                $lot->status_id = Status::where('code', $type)->first()['id'];
            } else {
                $lastTradeMessage = \App\Models\TradeMessage::where(['lot_id' => $lot->id, 'param_type' => 'status_id'])->latest()->first();
                $lot->status_id = $lastTradeMessage->param;
            }
            $lot->save();
        }
    }


}
