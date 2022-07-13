<?php

namespace App\Http\Services\Parse\TradeMessages;

class NewTradeOrganizer extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        logger('NEWTRADEORG');
        logger($invitation);
        try {

        } catch (\Exception $e) {
            logger('newTradeOrganizerExc: ' . $e);
            logger($invitation);
        }
    }
}
