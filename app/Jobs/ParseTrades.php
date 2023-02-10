<?php

namespace App\Jobs;

use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\GetTradeMessages;
use App\Http\Services\Parse\SoapWrapperService;
use App\Models\TradeMessage;
use App\Models\TradePlace;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\MaxAttemptsExceededException;
use Illuminate\Queue\SerializesModels;

class ParseTrades implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $startFrom;
    protected $endTo;
    protected $service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($startFrom = null, $endTo = null)
    {
        if (!is_null($startFrom) && !is_null($endTo)) {
            $this->startFrom = $startFrom;
            $this->endTo = $endTo;
        } else {
            $this->startFrom = Carbon::now()->setTimezone('Europe/Moscow')->subHour()->format('Y-m-d\TH:i:s');
            $this->endTo = Carbon::now()->setTimezone('Europe/Moscow')->format('Y-m-d\TH:i:s');
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger('START:' . $this->startFrom);
        logger('END:' . $this->endTo);
        $startFrom = $this->startFrom;
        $endTo = $this->endTo;
        $soapWrapper = new SoapWrapper();
        $service = new SoapWrapperService($soapWrapper);
        $messages = $service->getTradeMessages($startFrom, $endTo);
        $this->service = $service;
        foreach ($messages as $value) {
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
                $getTradeMessageContent->switchMessageType($tradePlaceId, $messageId, $messageGUID);
            }
        } catch (\Exception $e) {
            logger('ParseTrades. Error = ' . $e->getMessage() .' '. $e->getLine(). ' for MessageId = ' . $messageId);
            logger($e);
        }
    }
}
