<?php

namespace App\Jobs;

use App\Http\Services\SoapWrapperService;
use App\Models\CompanyTradeOrganizer;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
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
        $startFrom = Carbon::now()->subHour()->format('Y-m-d\TH:i:s');
        $soapWrapper = new SoapWrapper();
        $service = new SoapWrapperService($soapWrapper);
        $organizers = get_object_vars($service->getCompanyTradeOrganizerRegister($startFrom));
        foreach ($organizers as $value) {
            foreach ($value as $person) {
                try {
                    if (CompanyTradeOrganizer::where('inn', $person->INN)->exists()) {
                        $organizer = CompanyTradeOrganizer::where('inn', $person->INN)->first();
                        if ($organizer->date_of_last_modifier == $person->DateLastModif) {
                            continue;
                        }
                    } else {
                        $organizer = new CompanyTradeOrganizer();
                    }

                    $organizer->name = $person->FullName;
                    $organizer->short_name = $person->ShortName;
                    $organizer->inn = $person->INN; //array_key_exists('INN', $person) ? $person->INN : NULL;
                    $organizer->ogrn = $person->OGRN;//array_key_exists('OGRN', $person) ? $person->OGRN : NULL;
                    $organizer->date_of_last_modifier = $person->DateLastModif;
                    $organizer->save();
                } catch (\Exception $e) {
                    logger('ParseCompanyTradeOrganizerExc: ' . $e);
                }
            }
        }
    }
}
