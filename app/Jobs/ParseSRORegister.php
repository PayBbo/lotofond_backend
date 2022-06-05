<?php

namespace App\Jobs;

use App\Http\Services\SoapWrapperService;
use App\Models\ArbitrManager;
use App\Models\SroAu;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseSRORegister implements ShouldQueue
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
        $sros = get_object_vars($service->getSroRegister($startFrom));
        foreach ($sros as $value) {
            foreach ($value as $sro) {
                try {
                    if (SroAu::where('inn', $sro->INN)->exists()) {
                        $sro_au = SroAu::where('inn', $sro->INN)->first();
                        if ($sro_au->date_of_last_modifier == $sro->DateLastModif) {
                            continue;
                        }
                    } else {
                        $sro_au = new SroAu();
                    }

                    $sro_au->name = $sro->FullName;
                    $sro_au->reg_num = $sro->RegNum;
                    $sro_au->inn = $sro->INN;
                    $sro_au->phone = $sro->Phone;
                    $sro_au->date_of_last_modifier = $sro->DateLastModif;
                    $sro_au->save();
                    if (is_null($sro->AMList)) {
                        continue;
                    }
                    foreach (get_object_vars($sro->AMList) as $value)
                        foreach ($value as $person) {
                            if (ArbitrManager::where('arbitr_manager_id', $person->ArbitrManagerID)->exists()) {
                                $manager = ArbitrManager::where('arbitr_manager_id', $person->ArbitrManagerID)->first();
                                if ($manager->date_of_last_modifier == $person->DateLastModif) {
                                    $manager->sro_au_id = $sro_au->id;
                                    $manager->save();
                                    continue;
                                }
                            } else {
                                $manager = new ArbitrManager();
                            }

                            $manager->arbitr_manager_id = $person->ArbitrManagerID;
                            $manager->name = $person->LastName . ' ' . $person->FirstName . ' ' . $person->MiddleName;
                            $manager->inn = $person->INN; //array_key_exists('INN', $person) ? $person->INN : NULL;
                            $manager->reg_num = array_key_exists('RegNum', $person) ? $person->RegNum : NULL;
                            $manager->sro_au_id = $sro_au->id;
                            $manager->date_of_last_modifier = $person->DateLastModif;
                            $manager->save();

                        }
                } catch (\Exception $e) {
                    logger('ParseSROExc: ' . $e);
                }
            }
        }
    }
}
