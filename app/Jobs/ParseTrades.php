<?php

namespace App\Jobs;

use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\SoapWrapperService;
use App\Models\TradePlace;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseTrades implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $startFrom = Carbon::now()->subHour()->format('Y-m-d\TH:i:s');
        $endTo = Carbon::now()->format('Y-m-d\TH:i:s');
        $soapWrapper = new SoapWrapper();
        $service = new SoapWrapperService($soapWrapper);
        $messages = $service->getTradeMessages($startFrom, $endTo);
        foreach ($messages as $value) {
            foreach ($value as $message) {
                $tradePlace = TradePlace::where('inn', $message->INN)->first();
                if (!$tradePlace) {
                    $tradePlace = new TradePlace();
                    $tradePlace->inn = $message->INN;
                    $tradePlace->name = $message->Name;
                    $tradePlace->site = $message->Site;
                    $tradePlace->owner_name = $message->OwnerName;
                    $tradePlace->save();
                }
                if ($message->TradeList) {
                    foreach (get_object_vars($message->TradeList) as $val) {
                            foreach ($val as $trade) {
                                if (gettype($trade) == 'string') {
                                    //$item = json_decode($item);
                                    continue;
                                }
                                if (!array_key_exists('MessageList', $trade)) {
                                    if (gettype($trade->TradeMessage) == 'object') {
                                        $xml = $service->getTradeMessageContent($trade->TradeMessage->ID);
                                        $get_trade_message_content = new GetTradeMessageContent($xml, $trade->TradeMessage->Type);
                                        $get_trade_message_content->switchMessageType($tradePlace->id, $trade, $trade->TradeMessage->ID);
                                    } else {
                                        foreach ($trade->TradeMessage as $message) {
                                            $xml = $service->getTradeMessageContent($message->ID);
                                            $get_trade_message_content = new GetTradeMessageContent($xml, $message->Type);
                                            $get_trade_message_content->switchMessageType($tradePlace->id, $trade, $message->ID);
                                        }
                                    }
                                    continue;
                                }
                                foreach (get_object_vars($trade->MessageList) as $item) {
                                    if (gettype($item) == 'string') {
                                        $item = json_decode($item);
                                    }
                                    if (gettype($item) == 'object') {
                                        $xml = $service->getTradeMessageContent($item->ID);
                                        $get_trade_message_content = new GetTradeMessageContent($xml, $item->Type);
                                        $get_trade_message_content->switchMessageType($tradePlace->id, $trade, $item->ID);

                                    }
                                    if (gettype($item) == 'array') {
                                        foreach ($item as $i) {
                                            $xml = $service->getTradeMessageContent($i->ID);
                                            try {
                                            $get_trade_message_content = new GetTradeMessageContent($xml, $i->Type);
                                            $get_trade_message_content->switchMessageType($tradePlace->id, $trade, $i->ID);
                                            } catch (\Exception $e) {
                                                logger($i);
                                                logger($xml);
                                            }
                                        }
                                    }

                                }
                            }
                    }
                }
            }
        }
    }
}
