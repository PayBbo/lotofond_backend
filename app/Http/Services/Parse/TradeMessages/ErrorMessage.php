<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Auction;

class ErrorMessage extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        $auction = $this->auction;
        try {
            foreach ($auction->lots as $lot) {
                $tradeMessage = $this->createNotification($lot->id, $invitation['@attributes']['EventTime'],
                    null, null, $invitation['Text']);
            }

        } catch (\Exception $e) {
            logger('errorMessageExc: ' . $e);
            logger($invitation);
        }
    }
}
