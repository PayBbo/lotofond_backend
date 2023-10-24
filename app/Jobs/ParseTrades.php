<?php

namespace App\Jobs;

use App\Http\Services\CacheService;
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
use Illuminate\Support\Facades\Cache;

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
            $this->startFrom = Carbon::now()->setTimezone('Europe/Moscow')->subMinutes(15)->format('Y-m-d\TH:i:s');
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
        $startFrom = $this->startFrom;
        $endTo = $this->endTo;
        $soapWrapper = new SoapWrapper();
        $this->service = new SoapWrapperService($soapWrapper);
        $messages = $this->service->getTradeMessages($startFrom, $endTo);
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
                                    $this->getMessageContent($val->MessageList->TradeMessage->ID, $val->MessageList->TradeMessage->Type, $tradePlace->id, $val->GUID);
                                }
                                continue;
                            }
                            foreach ($val as $trade) {
                                if (array_key_exists('TradeMessage', $trade)) {
                                    if (gettype($trade->TradeMessage) == 'object') {
                                        $this->getMessageContent($trade->TradeMessage->ID, $trade->TradeMessage->Type, $tradePlace->id, $trade->GUID);
                                    } else {
                                        foreach ($trade->TradeMessage as $message) {
                                            $this->getMessageContent($message->ID, $message->Type, $tradePlace->id, $trade->GUID);
                                        }
                                    }
                                } else {
                                    foreach (get_object_vars($trade->MessageList) as $item) {
                                        if (gettype($item) == 'string') {
                                            $item = json_decode($item);
                                        }
                                        if (gettype($item) == 'object') {
                                            $this->getMessageContent($item->ID, $item->Type, $tradePlace->id, $trade->GUID);
                                        }
                                        if (gettype($item) == 'array') {
                                            foreach ($item as $i) {
                                                $this->getMessageContent($i->ID, $i->Type, $tradePlace->id, $trade->GUID);
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
                    $this->getMessageContent($message->TradeMessage->ID, $message->TradeMessage->Type, $tradePlace->id, $message->GUID);
                }
            }
        }
        $this->finishJob();
    }

    private function getMessageContent($messageId, $messageType, $tradePlaceId, $messageGUID)
    {
        try {
            $tradeMessage = TradeMessage::where('number', $messageId)->first();
            if (!$tradeMessage) {
                $xml = $this->service->getTradeMessageContent($messageId);
                $getTradeMessageContent = new GetTradeMessageContent($xml, $messageType);
                $getTradeMessageContent->switchMessageType($tradePlaceId, $messageId, $messageGUID);
            }
        } catch (\Exception $e) {
            if(str_contains($e->getMessage(), 'Access Denied')){
                dispatch((new AccessDeniedJob($messageId, $messageType, $messageGUID, $tradePlaceId))
                    ->delay(now()->setTimezone('Europe/Moscow')->addMinutes(5))
                    ->onQueue('parse'));
            }else {
                logger('ParseTrades. Error = ' . $e->getMessage() . ' ' . $e->getLine() . ' for MessageId = ' . $messageId);
                logger($e);
            }
        }
    }

    private function finishJob(){
        $cacheService = new CacheService();
        $cacheService->cacheCategoriesStatistics();
        $cacheService->cacheLotsStatistics();
        $cacheService->cachePricesForFilter();
        logger('END:' . $this->endTo);
    }


}
