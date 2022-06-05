<?php

namespace App\Jobs;

use App\Http\Services\SoapWrapperService;
use App\Models\Debtor;
use App\Models\DebtorCategory;
use App\Models\Region;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PHPUnit\Exception;

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
        $startFrom = Carbon::now()->subHour()->format('Y-m-d\TH:i:s');
        $soapWrapper = new SoapWrapper();
        $service = new SoapWrapperService($soapWrapper);
        $debtors = get_object_vars($service->getDebtorRegister($startFrom));
        foreach ($debtors as $value) {
            foreach ($value as $person) {
                try {
                    if (Debtor::where('bankrupt_id', $person->BankruptId)->exists()) {
                        $debtor = Debtor::where('bankrupt_id', $person->BankruptId)->first();
                        if ($debtor->date_of_last_modifier == $person->DateLastModif) {
                            continue;
                        }
                    } else {
                        $debtor = new Debtor();
                    }
                    $region = Region::where('title', $person->Region)->first();
                    if (!$region) {
                        $region = Region::create(['title' => $person->Region]);
                    }
                    if (array_key_exists('FullName', $person)) {
                        $name = $person->FullName;
                    } else {
                        $name = $person->LastName . ' ' . $person->FirstName;
                        if (array_key_exists('MiddleName', $person)) {
                            $name .= ' ' . $person->MiddleName;
                        }
                    }
                    $debtor->bankrupt_id = $person->BankruptId;
                    $debtor->name = $name;
                    $debtor->inn = array_key_exists('INN', $person) ? $person->INN : NULL;
                    $debtor->snils = array_key_exists('SNILS', $person) ? $person->SNILS : NULL;
                    $debtor->short_name = array_key_exists('ShortName', $person) ? $person->ShortName : NULL;
                    $debtor->ogrn = array_key_exists('OGRN', $person) ? $person->OGRN : NULL;
                    $debtor->address = array_key_exists('Address', $person) ? $person->Address : $person->LegalAddress;
                    $debtor->region_id = $region->id;
                    $debtor->debtor_category_id = DebtorCategory::where('code', $person->CategoryCode)->first()['id'];
                    $debtor->ogrnip = array_key_exists('OGRNIP', $person) ? $person->OGRNIP : NULL;
                    $debtor->date_of_last_modifier = $person->DateLastModif;
                    $debtor->save();
                }catch(Exception $e){
                    logger('ParseDebitorsExc: '.$e);
                }
            }
        }
    }
}
