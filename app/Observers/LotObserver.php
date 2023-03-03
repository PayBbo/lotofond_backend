<?php

namespace App\Observers;

use App\Http\Services\CacheService;
use App\Jobs\SendApplication;
use App\Models\Lot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class LotObserver
{
    /**
     * Handle the Lot "created" event.
     *
     * @param \App\Models\Lot $lot
     * @return void
     */
    public function created(Lot $lot)
    {

    }

    /**
     * Handle the Lot "updated" event.
     *
     * @param \App\Models\Lot $lot
     * @return void
     */
    public function updated(Lot $lot)
    {
        //
    }

    /**
     * Handle the Lot "deleted" event.
     *
     * @param \App\Models\Lot $lot
     * @return void
     */
    public function deleted(Lot $lot)
    {
        $cacheService = new CacheService();
        $cacheService->cacheCategoriesStatistics();
        $cacheService->cacheLotsStatistics();
        $cacheService->cachePricesForFilter();
    }

    /**
     * Handle the Lot "restored" event.
     *
     * @param \App\Models\Lot $lot
     * @return void
     */
    public function restored(Lot $lot)
    {
        //
    }

    /**
     * Handle the Lot "force deleted" event.
     *
     * @param \App\Models\Lot $lot
     * @return void
     */
    public function forceDeleted(Lot $lot)
    {
        //
    }
}
