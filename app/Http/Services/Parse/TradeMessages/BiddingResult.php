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
                    logger('1 if');
                    $this->getBiddingResult($invitation[$prefix . 'LotList'][$prefix . 'LotTradeResult'], $auction, $invitation, $prefix);
                } else {
                    logger('foreach');
                    foreach ($invitation[$prefix . 'LotList'][$prefix . 'LotTradeResult'] as $item) {
                        $this->getBiddingResult($item, $auction, $invitation, $prefix);
                    }
                }
            } else {
                logger('else');
                $item = $invitation[$prefix . 'LotList'][$prefix . 'LotTradeResult'];
                $this->getBiddingResult($item, $auction, $invitation, $prefix);
            }
        } catch (\Exception $e) {
            logger('biddingResultMessageExc: ' . $e);
            logger($invitation);
        }
    }

    private function getBiddingResult($item, $auction, $invitation, $prefix)
    {
        $lot = $auction->lots->where('number', $item['@attributes']['LotNumber'])->first();
        if ($lot) {
            if (array_key_exists('FailureTradeResult', $item) || array_key_exists('SuccessTradeResult', $item)) {
                logger('FailureTradeResult || SuccessTradeResult');
                $tradeMessage = $this->createNotification($lot->id, $invitation['@attributes']['EventTime'],
                    $lot->status_id, 'status_id');
                $lot->status_id = Status::where('code', 'finished')->first()['id'];
                $lot->save();
                $this->parseFile($prefix, $item, $auction, $lot, $tradeMessage);
            }
            $biddingResult = null;
            if (array_key_exists('FailureTradeResult', $item)) {
                logger('FailureTradeResult');
                $item = $item['FailureTradeResult'];
                $biddingResult = \App\Models\BiddingResult::create([
                    'trade_message_id' => $tradeMessage->id,
                    'substantiation' => array_key_exists('Substantiation', $item) ? $item['Substantiation'] : null,
                    'end_price' => array_key_exists('@attributes', $item) ? $item['@attributes']['Price'] : null,
                ]);
                $this->parseParticipants($item, $biddingResult, 'Buyer');
            }
            if (array_key_exists('SuccessTradeResult', $item)) {
                logger('SuccessTradeResult');
                $item = $item['SuccessTradeResult'];
                $biddingResult = \App\Models\BiddingResult::create([
                    'trade_message_id' => $tradeMessage->id,
                    'end_price' => array_key_exists('@attributes', $item) ? $item['@attributes']['Price'] : null,
                ]);
                $this->parseParticipants($item, $biddingResult, 'Winner');
            }
            if (!is_null($biddingResult)) {
                logger('not is null');
                if (!is_null($biddingResult->end_price)) {
                    $priceReduction = new PriceReductionService();
                    $priceReduction->saveFinalPrice($biddingResult);
                }
                if (array_key_exists('Participants', $item) && array_key_exists('Participant', $item['Participants'])) {
                    foreach ($item['Participants']['Participant'] as $participant) {
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
        if (array_key_exists($type . 'Person', $item)) {
            $participantData = $item[$type . 'Person']['@attributes'];
        }
        if (array_key_exists($type . 'Company', $item)) {
            $participantData = $item[$type . 'Company']['@attributes'];
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
