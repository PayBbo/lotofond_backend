<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Lot;

class Annulment extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        try {
            $message = \App\Models\TradeMessage::where('number', $invitation['ID_Annulment'])->first();
            if($message){
                if(!is_null($message->param) && !is_null($message->param_type)){
                    $lot = Lot::find($message->lot_id);
                    if($message->param_type !== 'auction_dates' && $message->param_type !== 'organizer'){
                        $lot[$message->param_type] = $message->param;
                        $lot->save();
                    }else{
                        $auction = $lot->auction;
                        $auction->update(json_decode($message->param));
                    }
                }
                $tradeMessages =  \App\Models\TradeMessage::where('number', $invitation['ID_Annulment'])->get();
                foreach($tradeMessages as $tradeMessage){
                     $this->createNotification($tradeMessage->lot_id, $invitation['@attributes']['EventTime']);
                     $tradeMessage->delete();
                }
            }

        } catch (\Exception $e) {
            logger('annulmentMessageExc: ' . $e);
            logger($invitation);
        }
    }
}
