<?php

namespace App\Jobs;

use App\Http\Services\Parse\DescriptionExtractsService;
use App\Http\Services\Parse\PriceReductionService;
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
        /* $lotCount = Lot::where('processed_description', null)->count()+100;
         $maxValue = 0;
         while($maxValue < $lotCount) {
             $lots = Lot::where('processed_description', null)->skip($maxValue)->limit(100)->get();
             foreach ($lots as $lot) {
                 $descriptionExtracts = new DescriptionExtractsService();
                 $descriptionExtracts->getDescriptionExtracts($lot, $lot->description);
                 if (is_null($lot->min_price) && ($lot->auction->auctionType->title == 'PublicOffer' || $lot->auction->auctionType->title == 'ClosePublicOffer')) {
                     $prices = $lot->showPriceReductions->pluck('price')->toArray();
                     if (count($prices) > 0) {
                         $lot->min_price = min($prices);
                         $lot->save();
                     }
                 }
             }
             $maxValue+=100;
         }*/
/*
        $lotCount = Lot::where('is_processed', false)->count() + 100;
        $maxValue = 0;
        while ($maxValue < $lotCount) {
            $lots = Lot::where('is_processed', false)->skip($maxValue)->limit(100)->get();
            foreach ($lots as $lot) {
                logger($lot->id);
                $lot->params()->detach();
                $descriptionExtracts = new DescriptionExtractsService();
                $descriptionExtracts->getDescriptionExtracts($lot, $lot->description);
                logger('params success');
                if (is_null($lot->min_price) && !is_null($lot->price_reduction)) {
                    $priceReduction = new PriceReductionService();
                    $priceReduction->getPriceReduction($lot->price_reduction, $lot->id);
                    logger('priceRed success');
                    $prices = $lot->showPriceReductions->pluck('price')->toArray();
                    if (count($prices) > 0) {
                        $lot->min_price = min($prices);
                    }
                }
                $lot->is_processed = true;
                $lot->save();
            }
            $maxValue += 100;
        }*/

    }
}
