<?php

namespace App\Jobs;

use App\Http\Services\Parse\DescriptionExtractsService;
use App\Models\Lot;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MakeProcessedDescription implements ShouldQueue
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
        $lots = Lot::where('processed_description', null)->get();
        foreach($lots as $lot){
            $descriptionExtracts = new DescriptionExtractsService();
            $descriptionExtracts->getDescriptionExtracts($lot, $lot->description);
            if(is_null($lot->min_price) && ($lot->auction->auctionType->title == 'PublicOffer' || $lot->auction->auctionType->title == 'ClosePublicOffer')){
                $prices = $lot->showPriceReductions->pluck('price')->toArray();
                if (count($prices) > 0) {
                    $lot->min_price = min($prices);
                    $lot->save();
                }
            }
        }
    }
}
