<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Auction;

class BiddingNewTerm extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                $data = [
                    'TimeBeginRequest' => 'application_start_date',
                    'TimeEndRequest' => 'application_end_date',
                    'TimeBeginTrade' => 'event_start_date',
                    'TimeEndTrade' => 'event_end_date',
                    'TimeResult' => 'result_date'
                ];
                $result = [];
                $previousData = [];
                foreach($data as $key => $field){
                    if(array_key_exists($key, $invitation)){
                        $result[$field] = $invitation[$key];
                        $previousData[$field] = $auction[$field];
                    }
                }
                if(count($result)>0) {
                    foreach ($auction->lots as $lot) {
                        $tradeMessage = $this->createNotification($lot->id, $invitation['@attributes']['EventTime'],
                            json_encode($previousData), 'auction_dates');
                        $auction->update($result);
                    }
                }
            }
        } catch (\Exception $e) {
            logger('biddingNewTermExc: ' . $e);
            logger($invitation);
        }
    }
}
