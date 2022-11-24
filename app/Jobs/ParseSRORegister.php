<?php

namespace App\Jobs;

use App\Http\Services\Parse\BidderService;
use App\Http\Services\Parse\SoapWrapperService;
use App\Models\ArbitrManager;
use App\Models\SroAu;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\MaxAttemptsExceededException;
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
        $startFrom = Carbon::now()->setTimezone('Europe/Moscow')->subDay()->format('Y-m-d\TH:i:s');
        $soapWrapper = new SoapWrapper();
        $service = new SoapWrapperService($soapWrapper);
        $sros = get_object_vars($service->getSroRegister($startFrom));
        if (!array_key_exists('SRO', $sros)) {
            return;
        }
            foreach ($sros['SRO'] as $sro) {
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
                    foreach (get_object_vars($sro->AMList)['ArbitrManager'] as $person) {
                        try {
                            $bidder = get_object_vars($person);
                            if(gettype($bidder['DateAffiliations']->DateAffiliation) == 'object'){
                                $date_exclude = $bidder['DateAffiliations']->DateAffiliation->DateExclude;
                            }else{
                                $date_exclude = $bidder['DateAffiliations']->DateAffiliation[count($bidder['DateAffiliations']->DateAffiliation)-1]->DateExclude;
                            }
                            if (is_null($date_exclude)) {
                                if (array_key_exists('INN', $bidder) && $bidder['INN'] != "" && !is_null($bidder['INN'])) {
                                    $bidderParse = new BidderService('arbitr_manager', $bidder['INN'], 'person');
                                    $arb_manager = $bidderParse->saveBidder($bidder);
                                    $arb_manager->sro_au_id = $sro_au->id;
                                    $arb_manager->save();
                                }
                            }

                        } catch (\Exception $e) {
                            logger('ParseArbitrManagerExc: ' . $e);
                        }
                    }

                } catch (\Exception $e) {
                    logger('ParseSROExc: ' . $e);
                }
            }
        }

}
