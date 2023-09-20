<?php

namespace App\Jobs;

use App\Models\Lot;
use App\Models\Region;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FixLotRegionJob implements ShouldQueue
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
        $lots = Lot::whereHas('paramsLot', function($query) {
            return $query->where('param_id', 4);
        })->whereDoesntHave('regions', function ($query) {
            return $query->where('is_debtor_region', false);
        })->limit(500)->get();
        foreach ($lots as $lot){
            $cadastrals = $lot->params()->where('param_id', 4)->pluck('value')->toArray();
            foreach ($cadastrals as $cadastral){
                $objectRegion = substr($cadastral, 0, strpos($cadastral, ':'));
                $region = Region::where('numbers', 'LIKE', '%' . $objectRegion . '%')->first();
                if ($region) {
                    if (!$lot->objectRegions->contains($region)) {
                        $lot->regions()->attach($region, ['is_debtor_region' => false]);
                    }
                }
            }
        }
    }
}
