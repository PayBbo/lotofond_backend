<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Lot;
use App\Models\PriceReduction;

class Annulment extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        try {
            $message = \App\Models\TradeMessage::where('number', $invitation[$prefix . 'ID_Annulment'])->first();
            if ($message) {
                $lot = Lot::find($message->lot_id);
                if (!is_null($message->param) && !is_null($message->param_type)) {
                    if ($message->param_type !== 'auction_dates' && $message->param_type !== 'organizer' && $message->param_type !== 'current_price') {
                        $lot[$message->param_type] = $message->param;
                        $lot->save();
                    } elseif ($message->param_type === 'current_price') {
                        $param = json_decode($message->param);
                        if(!is_null($param['new_id'])){
                            PriceReduction::find($param['new_id'])->delete();
                        }
                        $priceReduction = PriceReduction::find($param['id']);
                        if($priceReduction->is_system){
                            $priceReduction->end_time =null;
                        }else{
                            $priceReduction->price =$param['price'];
                        }
                        $priceReduction->save();
                    } else {
                        $auction = $lot->auction;
                        $auction->update(json_decode($message->param));
                    }
                }

                $tradeMessages = \App\Models\TradeMessage::where('number', $invitation[$prefix . 'ID_Annulment'])->get();
                foreach ($tradeMessages as $tradeMessage) {
                    if($tradeMessage->value !== 'BiddingInvitation'){
                        $this->createNotification($tradeMessage->lot_id, $invitation['@attributes']['EventTime']);
                        $tradeMessage->delete();
                    }else{
                        $this->createNotification($tradeMessage->lot_id, $invitation['@attributes']['EventTime'], $lot->status_id, 'status_id');
                        $lot->status_id = 7;
                        $lot->save();
                    }
                }
            }

        } catch (\Exception $e) {
            logger('annulmentMessageExc: ' . $e);
            logger($invitation);
        }
    }
}
