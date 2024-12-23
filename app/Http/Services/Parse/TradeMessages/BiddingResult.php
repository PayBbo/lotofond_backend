<?php

namespace App\Http\Services\Parse\TradeMessages;

use App\Http\Services\Parse\BidderService;
use App\Http\Services\Parse\PriceReductionService;
use App\Models\Auction;
use App\Models\Bidder;
use App\Models\BiddingParticipant;
use App\Models\Status;

class BiddingResult extends TradeMessage implements TradeMessageContract
{
    public function response()
    {
        $invitation = $this->invitation;
        $prefix = $this->prefix;
        $auction = $this->auction;
        try {
            if (count($invitation[$prefix . 'LotList'][$prefix . 'LotTradeResult']) > 1) {
                if (array_key_exists('@attributes', $invitation[$prefix . 'LotList'][$prefix . 'LotTradeResult'])) {
                    $this->getBiddingResult($invitation[$prefix . 'LotList'][$prefix . 'LotTradeResult'], $auction, $invitation, $prefix);
                } else {
                    foreach ($invitation[$prefix . 'LotList'][$prefix . 'LotTradeResult'] as $item) {
                        $this->getBiddingResult($item, $auction, $invitation, $prefix);
                    }
                }
            } else {
                $item = $invitation[$prefix . 'LotList'][$prefix . 'LotTradeResult'];
                $this->getBiddingResult($item, $auction, $invitation, $prefix);
            }
        } catch (\Exception $e) {
            logger('biddingResultMessageExc: ' . $e);
        }
    }

    private function getBiddingResult($item, $auction, $invitation, $prefix)
    {
        $lot = $auction->lots->where('number', $item['@attributes']['LotNumber'])->first();
        if ($lot) {
            $failureKey = $this->searchKeyInArray($item, 'FailureTradeResult', $prefix);
            $successKey = $this->searchKeyInArray($item, 'SuccessTradeResult', $prefix);
            if (!is_null($failureKey) || !is_null($successKey)) {
                $tradeMessage = $this->createNotification($lot->id, $invitation['@attributes']['EventTime'],
                    $lot->status_id, 'status_id');
                $lot->status_id = Status::where('code', 'finished')->first()['id'];
                $lot->save();
                $this->parseFile($prefix, $item, $auction, $lot, $tradeMessage);
            }
            $biddingResult = null;
            if (!is_null($failureKey)) {
                $item = $item[$failureKey];
                $biddingResult = \App\Models\BiddingResult::create([
                    'trade_message_id' => $tradeMessage->id,
                    'substantiation' => array_key_exists('Substantiation', $item) ? $item['Substantiation'] : null,
                    'end_price' => array_key_exists('@attributes', $item) ? $item['@attributes']['Price'] : null,
                ]);
                $this->parseParticipants($item, $biddingResult, 'Buyer');
            }
            if (!is_null($successKey)) {
                $item = $item[$successKey];
                $biddingResult = \App\Models\BiddingResult::create([
                    'trade_message_id' => $tradeMessage->id,
                    'end_price' => array_key_exists('@attributes', $item) ? $item['@attributes']['Price'] : null,
                ]);
                $this->parseParticipants($item, $biddingResult, 'Winner');
            }
            if (!is_null($biddingResult)) {
                if (!is_null($biddingResult->end_price)) {
                    $priceReduction = new PriceReductionService();
                    $priceReduction->saveFinalPrice($biddingResult);
                }
                $participantsKey = $this->searchKeyInArray($item, 'Participants', $prefix);
                $participantKey = null;
                if(!is_null($participantsKey))
                    $participantKey = $this->searchKeyInArray($item[$participantsKey], 'Participant', $prefix);
                if (!is_null($participantKey)) {
                    foreach ($item[$participantsKey][$participantKey] as $participant) {
                        $this->parseParticipants($participant, $biddingResult, 'Participant');
                    }
                }
            }
        }
    }

    private function parseParticipants($item, $biddingResult, $type)
    {
        $participantData = null;
        $participantType = 'person';
        $keyPerson = $this->searchKeyInArray($item, $type . 'Person', $this->prefix);
        if (!is_null($keyPerson)) {
            $participantData = $item[$keyPerson]['@attributes'];
        }
        $keyCompany = $this->searchKeyInArray($item, $type . 'Company', $this->prefix);
        if (!is_null($keyCompany)) {
            $participantData = $item[$keyCompany]['@attributes'];
            $participantType = 'company';
        }
        if (!is_null($participantData)) {
            $participant = Bidder::where('inn', $participantData['INN'])->first();
            if (!$participant) {
                $bidderService = new BidderService('participant', $participantData['INN'], $participantType);
                $participant = $bidderService->saveBidder($participantData);
            }
            if (!BiddingParticipant::where(['bidding_result_id' => $biddingResult->id, 'bidder_id' => $participant->id])->exists()) {
                BiddingParticipant::create([
                    'bidding_result_id' => $biddingResult->id,
                    'bidder_id' => $participant->id,
                    'is_buyer' => $type == 'Buyer',
                    'is_winner' => $type == 'Winner'
                ]);
            }

        }
    }
}
