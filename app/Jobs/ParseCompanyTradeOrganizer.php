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
use Illuminate\Queue\MaxAttemptsExceededException;
use Illuminate\Queue\SerializesModels;

class ParseCompanyTradeOrganizer implements ShouldQueue
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
        $startFrom = Carbon::now()->setTimezone('Europe/Moscow')->subDay()->format('Y-m-d\TH:i:s');
        $soapWrapper = new SoapWrapper();
        $service = new SoapWrapperService($soapWrapper);
        $organizers = get_object_vars($service->getCompanyTradeOrganizerRegister($startFrom));
        try {
            if (array_key_exists('TradeOrganizer', $organizers)) {
                $bidder = get_object_vars($organizers['TradeOrganizer']);
                if(array_key_exists('INN', $organizers['TradeOrganizer'])){ if ($bidder['INN'] != "" && !is_null($bidder['INN'])) {
                    $bidderParse = new BidderService('organizer', $bidder['INN'], 'company');
                    $bidderParse->saveBidder($bidder);
                }
                }else {
                    foreach ($organizers['TradeOrganizer'] as $company) {
                        $bidder = get_object_vars($company);
                        if (array_key_exists('INN', $bidder) && $bidder['INN'] != "" && !is_null($bidder['INN'])) {
                            $bidderParse = new BidderService('organizer', $bidder['INN'], 'company');
                            $bidderParse->saveBidder($bidder);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            logger('ParseCompanyTradeOrganizerExc: ' . $e);
        }

    }
}
