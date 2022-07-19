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

class ParseDebtor implements ShouldQueue
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
        $startFrom = Carbon::now()->setTimezone('Europe/Moscow')->subHour()->format('Y-m-d\TH:i:s');
        $soapWrapper = new SoapWrapper();
        $service = new SoapWrapperService($soapWrapper);
        $debtors = get_object_vars($service->getDebtorRegister($startFrom));
        try {
            if (array_key_exists('DebtorPerson', $debtors)) {
                foreach ($debtors['DebtorPerson'] as $person) {
                    $bidder = get_object_vars($person);
                    if (array_key_exists('INN', $bidder) && $bidder['INN'] != "" && !is_null($bidder['INN'])) {
                        $bidderParse = new BidderService('debtor', $bidder['INN'], 'person');
                        $bidderParse->saveBidder($bidder);
                    }
                }
            }
            if (array_key_exists('DebtorCompany', $debtors)) {
                foreach ($debtors['DebtorCompany'] as $company) {
                    $bidder = get_object_vars($company);
                    if (array_key_exists('INN', $bidder) && $bidder['INN'] != "" && !is_null($bidder['INN'])) {
                        $bidderParse = new BidderService('debtor', $bidder['INN'], 'company');
                        $bidderParse->saveBidder($bidder);
                    }
                }
            }


        } catch (\Exception $e) {
            logger('ParseDebtorExc: ' . $e);
        }

    }
}
