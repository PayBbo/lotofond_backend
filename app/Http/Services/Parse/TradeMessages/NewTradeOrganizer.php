<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Http\Services\Parse\BidderService;
use App\Models\Auction;
use App\Models\Bidder;

class NewTradeOrganizer extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                $tradeOrganizer = null;
                $org_type = 'person';
                if(array_key_exists($prefix .'TradeOrganizerPerson', $invitation)) {
                    $tradeOrganizer = $invitation[$prefix .'TradeOrganizerPerson']['@attributes'];
                }elseif(array_key_exists($prefix .'TradeOrganizerCompany', $invitation)){
                    $tradeOrganizer = $invitation[$prefix .'TradeOrganizerCompany']['@attributes'];
                    $org_type = 'company';
                }
                if(!is_null($tradeOrganizer)){
                    $bidder = Bidder::where('inn', $tradeOrganizer['INN'])->first();
                    if(!$bidder){
                        if (array_key_exists('INN',   $tradeOrganizer) &&   $tradeOrganizer['INN'] != "" && !is_null(  $tradeOrganizer['INN'])) {
                            $orgParse = new BidderService('organizer',   $tradeOrganizer['INN'], $org_type);
                            $bidder = $orgParse->saveBidder(  $tradeOrganizer);
                        }
                    }
                    if($bidder){
                        foreach ($auction->lots as $lot) {
                            $tradeMessage = $this->createNotification($lot->id, $invitation['@attributes']['EventTime'],
                               json_encode(['company_trade_organizer_id'=> $auction->company_trade_organizer_id]), 'organizer');
                            $auction->company_trade_organizer_id = $bidder->id;
                            $auction->save();
                        }
                    }
                }

            }
        } catch (\Exception $e) {
            logger('newTradeOrganizerExc: ' . $e);
            logger($invitation);
        }
    }
}
