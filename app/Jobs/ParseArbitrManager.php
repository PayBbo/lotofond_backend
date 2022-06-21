<?php

namespace App\Jobs;

use App\Http\Services\Parse\BidderService;
use App\Http\Services\Parse\SoapWrapperService;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseArbitrManager implements ShouldQueue
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
        $soapWrapper = new SoapWrapper();
        $service = new SoapWrapperService($soapWrapper);
        $managers = get_object_vars($service->getArbitrManagerRegister($startFrom));
        if(!array_key_exists('ArbitrManager', $managers)){
            return;
        }
        foreach ($managers['ArbitrManager'] as $person) {
            try {
                $bidder = get_object_vars($person);
                if (array_key_exists('INN', $bidder) && $bidder['INN'] != "" && !is_null($bidder['INN'])) {
                    $bidderParse = new BidderService('arbitr_manager', $bidder['INN'], 'person');
                    $bidderParse->saveBidder($bidder);
                } else {
                    continue;
                }

            } catch (\Exception $e) {
                logger('ParseArbitrManagerExc: ' . $e);
            }
        }

    }
}
