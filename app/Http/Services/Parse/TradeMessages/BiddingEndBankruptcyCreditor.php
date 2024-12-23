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
        $auction = $this->auction;
        try {
            if (array_key_exists($prefix . 'CreditorLotNumberList', $invitation)) {
                $lotList = $invitation[$prefix . 'CreditorLotNumberList'][$prefix . 'CreditorLotNumber'];
                if (count($lotList) > 1) {
                    foreach ($lotList as $lot) {
                        $this->changeStatus($auction, $lot);
                    }
                } else {
                    $this->changeStatus($auction, $lotList);
                }
            } elseif (array_key_exists($prefix . 'CreditorLotNumberList', $invitation[$prefix . 'BankruptcyCreditorList'])) {
                $lotList = $invitation[$prefix . 'BankruptcyCreditorList'][$prefix . 'CreditorLotNumberList'][$prefix . 'CreditorLotNumber'];
                if (count($lotList) > 1) {
                    foreach ($lotList as $lot) {
                        $this->changeStatus($auction, $lot);
                    }
                } else {
                    $this->changeStatus($auction, $lotList);
                }
            } elseif (array_key_exists($prefix . 'BankruptcyCreditor', $invitation[$prefix . 'BankruptcyCreditorList']) && array_key_exists($prefix . 'CreditorLotNumberList', $invitation[$prefix . 'BankruptcyCreditorList'][$prefix . 'BankruptcyCreditor'])) {
                $lotList = $invitation[$prefix . 'BankruptcyCreditorList'][$prefix . 'BankruptcyCreditor'][$prefix . 'CreditorLotNumberList'][$prefix . 'CreditorLotNumber'];
                if (count($lotList) > 1) {
                    foreach ($lotList as $lot) {
                        $this->changeStatus($auction, $lot);
                    }
                } else {
                    $this->changeStatus($auction, $lotList);
                }
            } else {
                foreach ($auction->lots as $lot) {
                    $this->changeStatus($auction, $lot);
                }
            }
        } catch (\Exception $e) {
            logger('BiddingEndBankruptcyCreditorExc: ' . $e);
        }

    }

    private function changeStatus($auction, $lot)
    {
        if (array_key_exists('@attributes', $lot) && array_key_exists('LotNumber', $lot['@attributes'])) {
            $auction_lot = $auction->lots->where('number', $lot['@attributes']['LotNumber'])->first();
        } else {
            $auction_lot = $auction->lots->where('number', $lot['CreditorLotNumberList']['CreditorLotNumber']['@attributes']['LotNumber'])->first();
        }
        if ($auction_lot) {
            $this->createNotification($auction_lot->id, $this->invitation['@attributes']['EventTime'], $auction_lot->status_id, 'status_id');
            $auction_lot->status_id = Status::where('code', 'finished')->first()['id'];
            $auction_lot->save();
        }
    }
}
