<?php

namespace App\Http\Services\Parse;

use App\Models\TradeMessage;
use App\Models\TradePlace;
use Artisaninweb\SoapWrapper\SoapWrapper;

class GetTradeMessages
{

    protected $messages;
    protected $service;

    public function __construct($messages, $service)
    {
        $this->messages = $messages;
        $this->service = $service;
    }

    public function getMessages()
    {
        foreach ($this->messages as $value) {
            foreach ($value as $message) {
                if (gettype($message) == 'string') {
                    $message = $value;
                }
                if (!array_key_exists('INN', $message)) {
                    continue;
                }
                $tradePlace = TradePlace::where('inn', $message->INN)->first();
                if (!$tradePlace) {
                    $tradePlace = new TradePlace();
                    $tradePlace->inn = $message->INN;
                    $tradePlace->name = $message->Name;
                    $tradePlace->site = $message->Site;
                    $tradePlace->owner_name = $message->OwnerName;
                    $tradePlace->save();
                }
                if (array_key_exists('TradeList', $message)) {
                    try {
                        foreach (get_object_vars($message->TradeList) as $val) {
                            if (gettype($val) === 'string') {
                                $val = json_decode($val);
                            }
                            if (array_key_exists('ID', $val)) {
                                $this->getMessageContent($val->ID, $val->Type, $tradePlace->id, $val->GUID);
                                continue;
                            }
                            if (gettype($val) == 'object') {
                                if (gettype($val->MessageList->TradeMessage) == 'array') {
                                    foreach ($val->MessageList->TradeMessage as $item) {
                                        $this->getMessageContent($item->ID, $item->Type, $tradePlace->id, $item->GUID);
                                    }
                                } else {
                                    $this->getMessageContent($val->MessageList->TradeMessage->ID, $val->MessageList->TradeMessage->Type, $tradePlace->id, $val->MessageList->TradeMessage->GUID);
                                }
                                continue;
                            }
                            foreach ($val as $trade) {
                                if (array_key_exists('TradeMessage', $trade)) {
                                    if (gettype($trade->TradeMessage) == 'object') {
                                        $this->getMessageContent($trade->TradeMessage->ID, $trade->TradeMessage->Type, $tradePlace->id, $trade->TradeMessage->GUID);
                                    } else {
                                        foreach ($trade->TradeMessage as $message) {
                                            $this->getMessageContent($message->ID, $message->Type, $tradePlace->id, $message->GUID);
                                        }
                                    }
                                } else {
                                    foreach (get_object_vars($trade->MessageList) as $item) {
                                        if (gettype($item) == 'string') {
                                            $item = json_decode($item);
                                        }
                                        if (gettype($item) == 'object') {
                                            $this->getMessageContent($item->ID, $item->Type, $tradePlace->id, $item->GUID);
                                        }
                                        if (gettype($item) == 'array') {
                                            foreach ($item as $i) {
                                                $this->getMessageContent($i->ID, $i->Type, $tradePlace->id, $i->GUID);
                                            }
                                        }

                                    }
                                }
                            }
                        }
                    } catch (\Exception $e) {
                        logger('ParseTrades');
                        logger(json_encode($message));
                        logger($e);
                    }
                } else {
                    $this->getMessageContent($message->TradeMessage->ID, $message->TradeMessage->Type, $tradePlace->id, $message->TradeMessage->GUID);
                }
            }
        }
    }

    private function getMessageContent($messageId, $messageType, $tradePlaceId, $messageGUID, $mustCheck = true)
    {
        try {
            if (!TradeMessage::where('number', $messageId)->exists()) {
                $xml = $this->service->getTradeMessageContent($messageId);
                $getTradeMessageContent = new GetTradeMessageContent($xml, $messageType);
                $getTradeMessageContent->switchMessageType($tradePlaceId, $messageId, $messageGUID, $mustCheck);
            }
        } catch (\Exception $e) {
            logger('ParseTrades. Error = ' . $e->getMessage() .' '. $e->getLine(). ' for MessageId = ' . $messageId);
            logger($e);
        }
    }


    public function checkIsAuctionMessage($messageId)
    {
        $isExists = false;
        $tradePlace = TradePlace::where('inn', $this->messages->TradePlace->INN)->first();
        try {
            if (property_exists( $this->messages->TradePlace, 'TradeList')) {
                $tradeList = $this->messages->TradePlace->TradeList;
                if (property_exists( $tradeList, 'Trade')) {
                    $trade = $tradeList->Trade;
                    if (property_exists( $trade, 'MessageList')) {
                        $messageList = $trade->MessageList;
                        if (property_exists( $messageList, 'TradeMessage')) {
                            $tradeMessages = $messageList->TradeMessage;
                            if (gettype($tradeMessages) == 'array') {
                                foreach ($tradeMessages as $tradeMessage) {
                                    if ($tradeMessage->ID == $messageId) {
                                        $isExists = true;
                                    } else {
                                        $this->getMessageContent($tradeMessage->ID, $tradeMessage->Type, $tradePlace->id, $tradeMessage->GUID, false);
                                    }
                                }
                            }
                        } else {
                            logger('TradeMessage not exists');
                            logger(json_encode($messageList));
                        }

                    } else {
                        logger('MessageList not exists');
                        logger(json_encode($trade));
                    }

                } else {
                    logger('Trade not exists');
                    logger(json_encode($tradeList));
                }

            } else {
                logger('TradeList not exists');
                logger(json_encode($this->messages));

            }
            return $isExists;
        }catch (\Exception $e){
            logger($e);
            logger(json_encode($this->messages));
        }
    }
}
