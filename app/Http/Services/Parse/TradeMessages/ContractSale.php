<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Models\Auction;
use App\Models\Bidder;
use App\Models\BiddingParticipant;
use App\Models\BiddingResult;
use Carbon\Carbon;

class ContractSale extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        $auction = $this->auction;
        try {
            if (count($invitation[$prefix . 'LotContractSaleList']) > 2) {
                foreach ($invitation[$prefix . 'LotContractSaleList'] as $item) {
                    $lot = $auction->lots->where('number', $item[$prefix . 'LotContractSale']['@attributes']['LotNumber'])->first();
                    if ($lot) {
                        $this->saveBiddingResult($lot, $invitation, $prefix);
                    }
                }
            } elseif (array_key_exists('0', $invitation[$prefix . 'LotContractSaleList'][$prefix . 'LotContractSale'])) {
                foreach ($invitation[$prefix . 'LotContractSaleList'][$prefix . 'LotContractSale'] as $item) {
                    $lot = $auction->lots->where('number', $item['@attributes']['LotNumber'])->first();
                    if ($lot) {
                        $this->saveBiddingResult($lot, $invitation, $prefix, $item);
                    }
                }
            } else {
                $lot = $auction->lots->where('number', $invitation[$prefix . 'LotContractSaleList'][$prefix . 'LotContractSale']['@attributes']['LotNumber'])->first();
                if ($lot) {
                    $this->saveBiddingResult($lot, $invitation, $prefix);
                }
            }

        } catch (\Exception $e) {
            logger('contractSaleMessageExc: ' . $e);
            logger($invitation);
        }
    }

    private function saveBiddingResult($lot, $invitation, $prefix, $data = null)
    {
        $tradeMessage = $this->createNotification($lot->id, $invitation['@attributes']['EventTime']);
        if (is_null($data)) {
            $data = $invitation[$prefix . 'LotContractSaleList'][$prefix . 'LotContractSale'];
        }
        if (array_key_exists('@attributes', $data[$prefix . 'ContractParticipantList'][$prefix . 'ContractParticipant'])) {
            $participantData = $data[$prefix . 'ContractParticipantList'][$prefix . 'ContractParticipant']['@attributes'];
            $this->saveParticipant($lot, $participantData, $data, $tradeMessage);
        } else {
            foreach ($data[$prefix . 'ContractParticipantList'][$prefix . 'ContractParticipant'] as $item) {
                $participantData = $item['@attributes'];
                $this->saveParticipant($lot, $participantData, $data, $tradeMessage);
            }
        }

    }

    private function saveParticipant($lot, $participantData, $data, $tradeMessage)
    {
        if (BiddingResult::whereIn('trade_message_id', $lot->tradeMessages()->pluck('id'))->count() > 0) {
            if (array_key_exists('INN', $participantData)) {
                $inn = $participantData['INN'];
                $isExists = false;
                foreach ($lot->tradeMessages as $message) {
                    foreach ($message->biddingResults as $result) {
                        $biddingResult = $result->biddingParticipants()->whereHas('bidder', function ($q) use ($inn) {
                            $q->where('inn', $inn);
                        })
                            ->where(['is_winner' => $participantData['IsWinner'], 'is_buyer' => $participantData['IsBuyer']])
                            ->first();
                        if ($biddingResult) {
                            $biddingResult->contract_number = array_key_exists($this->prefix . 'ContractNumber', $data[$this->prefix . 'ContractInfo']) ?
                                $data[$this->prefix . 'ContractInfo'][$this->prefix . 'ContractNumber'] : null;
                            $biddingResult->contract_date = $this->parseDate($data[$this->prefix . 'ContractInfo'][$this->prefix . 'DateContract']);
                            $biddingResult->end_price = $data[$this->prefix . 'ContractInfo'][$this->prefix . 'Price'];
                            $biddingResult->save();
                            $isExists = true;
                            break;
                        }
                    }
                }
                if (!$isExists) {
                    $this->saveContractSale($data, $tradeMessage);
                }
            }
        } else {
            $this->saveContractSale($data, $tradeMessage);
        }
    }

    private function saveContractSale($data, $tradeMessage)
    {
        $biddingResult = new \App\Models\BiddingResult();
        if (array_key_exists($this->prefix . 'ContractInfo', $data)) {
            $biddingResult->contract_number = array_key_exists($this->prefix . 'ContractNumber', $data[$this->prefix . 'ContractInfo']) ?
                $data[$this->prefix . 'ContractInfo'][$this->prefix . 'ContractNumber'] : null;
            $biddingResult->contract_date = array_key_exists($this->prefix . 'DateContract', $data[$this->prefix . 'ContractInfo']) ? $data[$this->prefix . 'ContractInfo'][$this->prefix . 'DateContract'] : null;
            $biddingResult->end_price = array_key_exists($this->prefix . 'Price', $data[$this->prefix . 'ContractInfo']) ? $data[$this->prefix . 'ContractInfo'][$this->prefix . 'Price'] : null;
        } else {
            $biddingResult->contract_date = $this->invitation['@attributes']['EventTime'];
            $biddingResult->end_price = array_key_exists('Price', $this->invitation['@attributes']) ? $this->invitation['@attributes']['Price'] : null;
        }
        $biddingResult->trade_message_id = $tradeMessage->id;
        $biddingResult->save();
        if (count($data[$this->prefix . 'ContractParticipantList'][$this->prefix . 'ContractParticipant']) > 1) {
            foreach ($data[$this->prefix . 'ContractParticipantList'][$this->prefix . 'ContractParticipant'] as $participant) {
                $participantData = $participant['@attributes'];
                $this->saveBidder($participantData, $biddingResult);
            }
        } else {
            $participantData = $data[$this->prefix . 'ContractParticipantList'][$this->prefix . 'ContractParticipant']['@attributes'];
            $this->saveBidder($participantData, $biddingResult);
        }


    }

    private function saveBidder($participantData, $biddingResult)
    {
        if (array_key_exists('INN', $participantData)) {
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
                    'is_buyer' => $participantData['IsBuyer'] == 'true',
                    'is_winner' => $participantData['IsWinner'] == 'true'
                ]);
            }
        }
    }
}
