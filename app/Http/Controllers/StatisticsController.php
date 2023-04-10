<?php

namespace App\Http\Controllers;


use App\Http\Services\CacheService;
use Illuminate\Support\Facades\Cache;

class StatisticsController extends Controller
{

    public function getStatisticsByCategories(){

        if (!Cache::has('categoriesStatistics')) {
            $cacheService = new CacheService();
            $cacheService->cacheCategoriesStatistics();
        }

        $data = Cache::get('categoriesStatistics');
        return response($data, 200);
    }

    public function getStatisticsByLots(){

        if (!Cache::has('lotsStatistics')) {
            $cacheService = new CacheService();
            $cacheService->cacheLotsStatistics();
        }

        $data = Cache::get('lotsStatistics');
        if(!Cache::has('trialPeriod')){
            $cacheService = new CacheService();
            $cacheService->cacheTrialPeriod();
        }
        $data['trialPeriod'] =  (integer)Cache::get('trialPeriod');
        return response($data, 200);

    }
}
