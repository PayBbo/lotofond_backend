<?php

namespace App\Jobs;

use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\SoapWrapperService;
use App\Models\TradeMessage;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class AccessDeniedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messageId;
    protected $messageType;
    protected $messageGUID;
    protected $tradePlaceId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($messageId, $messageType, $messageGUID, $tradePlaceId)
    {
        $this->messageId = $messageId;
        $this->messageType = $messageType;
        $this->messageGUID = $messageGUID;
        $this->tradePlaceId = $tradePlaceId;
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [(new WithoutOverlapping($this->messageId))];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!TradeMessage::where('number', $this->messageId)->exists()) {
            $soapWrapper = new SoapWrapper();
            $service = new SoapWrapperService($soapWrapper);
            $xml = $service->getTradeMessageContent($this->messageId);
            $getTradeMessageContent = new GetTradeMessageContent($xml, $this->messageType);
            $getTradeMessageContent->switchMessageType($this->tradePlaceId, $this->messageId, $this->messageGUID);
        }
    }
}
