<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Auction;
use App\Models\LotApplication;

class ApplicationSessionStatistic extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        $auction = $this->auction;
        try {
            if (array_key_exists($prefix . 'LotList', $invitation)) {
                $lot = $invitation[$prefix . 'LotList'][$prefix . 'LotStatistic'];
                if (array_key_exists('@attributes', $lot)) {
                    $this->saveStatistics($auction, $lot, $prefix, $invitation);
                }
            }
        } catch (\Exception $e) {
            logger('applicationSessionStatistic: ' . $e);
            logger($invitation);
        }

    }

    private function saveStatistics($auction, $lot, $prefix, $invitation)
    {
        $auction_lot = $auction->lots->where('number', $lot['@attributes']['LotNumber'])->first();
        if ($auction_lot) {
            $tradeMessage = $this->createNotification($auction_lot->id, $invitation['@attributes']['EventTime']);
            $this->parseFile($prefix, $invitation, $auction, $auction_lot, $tradeMessage);
            if (array_key_exists($prefix . 'ApplicationList', $lot)) {
                $data = $lot[$prefix . 'ApplicationList'];
                if (array_key_exists('ApplicationData', $data)) {
                    foreach ($data['ApplicationData'] as $application) {
                        LotApplication::create([
                            'entry_count' => $lot['@attributes']['EntryCount'],
                            'accept_count' => $lot['@attributes']['AcceptCount'],
                            'result' => array_key_exists('Result', $application) ? $application['Result'] : null,
                            'cause_of_refuse' => array_key_exists('CauseOfRefuse', $application) ? $application['CauseOfRefuse'] : null,
                            'trade_message_id' => $tradeMessage->id
                        ]);
                    }
                }
            }
        }
    }
}
