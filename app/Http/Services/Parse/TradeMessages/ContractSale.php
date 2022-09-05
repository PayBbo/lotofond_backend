<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Auction;
use App\Models\Bidder;
use App\Models\BiddingParticipant;
use Carbon\Carbon;

class ContractSale extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        try {
            $auction = Auction::where('trade_id', $invitation['@attributes']['TradeId'])->first();
            if ($auction) {
                if (count($invitation[$prefix . 'LotContractSaleList']) > 2) {
                    foreach ($invitation[$prefix . 'LotContractSaleList'] as $item) {
                        $lot = $auction->lots->where('number', $item[$prefix . 'LotContractSale']['@attributes']['LotNumber'])->first();
                        if ($lot) {
                            $this->saveBiddingResult($lot, $invitation, $prefix);
                        }
                    }
                } else {
                    $lot = $auction->lots->where('number', $invitation[$prefix . 'LotContractSaleList'][$prefix . 'LotContractSale']['@attributes']['LotNumber'])->first();
                    if ($lot) {
                        $this->saveBiddingResult($lot, $invitation, $prefix);
                    }
                }
            }

        } catch (\Exception $e) {
            logger('contractSaleMessageExc: ' . $e);
            logger($invitation);
        }
    }

    public function saveBiddingResult($lot, $invitation, $prefix)
    {
        $tradeMessage = $this->createNotification($lot->id, $invitation['@attributes']['EventTime']);
        $data = $invitation[$prefix . 'LotContractSale'];
        $participantData = $data['ContractParticipantList']['ContractParticipant']['@attributes'];
        if ($lot->tradeMessages->biddingResults->count() > 0) {
            $inn = $participantData['INN'];
            $isExists = false;
            foreach ($lot->tradeMessages->biddingResults as $result) {
                $biddingResult = $result->biddingParticipants->whereHas('bidder', function ($q) use ($inn) {
                    $q->where('inn', $inn); })
                    ->where(['is_winner' => $participantData['IsWinner'], 'is_buyer' => $participantData['IsBuyer']])
                    ->first();
                if ($biddingResult) {
                    $biddingResult->contract_number = $data['ContractInfo']['ContractNumber'];
                    $biddingResult->contract_date =  Carbon::parse($data['ContractInfo']['DateContract'])->setTimezone('Europe/Moscow');
                    $biddingResult->price = $data['ContractInfo']['Price'];
                    $biddingResult->save();
                    $isExists = true;
                    break;
                }
            }
            if(!$isExists){
                $this->saveContractSale($data, $tradeMessage);
            }

        } else {
            $this->saveContractSale($data, $tradeMessage);
        }
    }

    public function saveContractSale($data, $tradeMessage)
    {
        $biddingResult = new \App\Models\BiddingResult();
        $biddingResult->contract_number = $data['ContractInfo']['ContractNumber'];
        $biddingResult->contract_date = $data['ContractInfo']['DateContract'];
        $biddingResult->price = $data['ContractInfo']['Price'];
        $biddingResult->trade_message_id = $tradeMessage->id;
        $biddingResult->save();
        $participantData = $data['ContractParticipantList']['ContractParticipant']['@attributes'];
        $bidder = Bidder::where('inn', $participantData['INN'])->first();
        if (!$bidder) {
            $bidder = Bidder::create([
                'name' => $participantData['Name'],
                'inn' => $participantData['INN']
            ]);
        }
        if (!BiddingParticipant::where(['bidding_result_id' => $biddingResult->id, 'bidder_id' => $bidder->id])->exists()) {
            BiddingParticipant::create([
                'bidding_result_id' => $biddingResult->id,
                'bidder_id' => $bidder->id,
                'is_buyer' => $participantData['IsBuyer'],
                'is_winner' => $participantData['IsWinner']
            ]);
        }
    }
}
