<?php

namespace App\Jobs;

use App\Http\Services\SoapWrapperService;
use App\Models\ArbitrManager;
use App\Models\Region;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
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
        foreach ($managers as $value) {
            foreach ($value as $person) {
                try {
                    if (ArbitrManager::where('arbitr_manager_id', $person->ArbitrManagerID)->exists()) {
                        $manager = ArbitrManager::where('arbitr_manager_id', $person->ArbitrManagerID)->first();
                        if ($manager->date_of_last_modifier == $person->DateLastModif) {
                            continue;
                        }
                    } else {
                        $manager = new ArbitrManager();
                    }
                    $region = Region::where('title', $person->Region)->first();
                    if (!$region) {
                        $region = Region::create(['title' => $person->Region]);
                    }

                    /* $name = $person->LastName . ' ' . $person->FirstName . ' ' . $person->MiddleName;
                      if (array_key_exists('MiddleName', $person)) {
                         $name .= ' ' . $person->MiddleName;
                     }*/

                    $manager->arbitr_manager_id = $person->ArbitrManagerID;
                    $manager->name = $person->LastName . ' ' . $person->FirstName . ' ' . $person->MiddleName;
                    $manager->inn = $person->INN; //array_key_exists('INN', $person) ? $person->INN : NULL;
                    $manager->reg_num = array_key_exists('RegNum', $person) ? $person->RegNum : NULL;
                    $manager->sro_reg_num = array_key_exists('SRORegNum', $person) ? $person->SRORegNum : NULL;
                    $manager->region_id = $region->id;
                    $manager->ogrnip = array_key_exists('OGRNIP', $person) ? $person->OGRNIP : NULL;
                    $manager->date_of_last_modifier = $person->DateLastModif;
                    $manager->save();

                } catch (\Exception $e) {
                    logger('ParseArbitrManagerExc: ' . $e);
                }
            }
        }
    }
}
