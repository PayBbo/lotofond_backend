<?php

namespace App\Jobs;

use App\Http\Services\Parse\GetTradeMessageContent;
use App\Http\Services\Parse\GetTradeMessages;
use App\Http\Services\Parse\SoapWrapperService;
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
        $getMessages = new GetTradeMessages($messages, $service);
        $getMessages->getMessages();
    }
}
