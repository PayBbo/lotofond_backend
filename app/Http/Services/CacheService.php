<?php

namespace App\Http\Services;

use App\Models\Category;
use App\Models\Lot;
use App\Models\PriceReduction;
use App\Models\RegionGroup;
use App\Models\Setting;
use App\Models\TradePlace;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class CacheService
{

    public function cachePricesForFilter(){
        Cache::put('prices', [
            "currentPrice" => [
                "min" => (float)PriceReduction::min('price'),
                "max" => (float)PriceReduction::max('price'),
            ],
            "startPrice" => [
                "min" => (float)Lot::min('start_price'),
                "max" => (float)Lot::max('start_price'),
            ],
            "minPrice" => [
                "min" => (float)Lot::min('min_price'),
                "max" => (float)Lot::max('min_price'),
            ]
        ], Carbon::now()->addHours(2));
    }

    public function cacheCategoriesStatistics(){
        $categories = Category::with('subcategories')
            ->whereNull('parent_id')
            ->get();

        $data = [];
        $active_statuses = [1, 2];

        foreach ($categories as $category) {
            $ids = $category->subcategories->pluck('title')->merge([$category->title]);

            $data[$category->title] = [
                'allLotsCount' => Lot::whereHas('categories', function ($q) use ($ids) {
                    $q->whereIn('categories.title', $ids);
                })->count(),
                'activeLotsCount' => Lot::whereIn('status_id', $active_statuses)
                    ->whereHas('categories', function ($q) use ($ids) {
                        $q->whereIn('categories.title', $ids);
                    })->count()
            ];
        }

        $data['all'] = [
            'allLotsCount' => Lot::count(),
            'activeLotsCount' => Lot::whereIn('status_id', $active_statuses)->count()
        ];
        Cache::put('categoriesStatistics', $data, Carbon::now()->addHours(2));
    }

    public function cacheLotsStatistics(){
        $active_statuses = [1, 2];
        $date = Carbon::now()->setTimezone('Europe/Moscow');
        $data = [
            'activeLotsCount'=>Lot::whereIn('status_id', $active_statuses)->count(),
            'nonactiveLotsCount'=>Lot::whereNotIn('status_id', $active_statuses)->count(),
            'allLotsCount'=>Lot::count(),
            'newLotsCount'=>Lot::whereDate('created_at',$date)->count()
        ];
        Cache::put('lotsStatistics', $data, Carbon::now()->addHours(2));
    }

    public function cacheTradePlacesForFilter(){
        Cache::put('tradePlaces', TradePlace::hasByNonDependentSubquery('auctionsWithLots')->orderBy('name', 'asc')->get());
    }

    public function cacheCategories(){
        $parents = Category::where('parent_id', null)->orderBy('label', 'asc')->get();
        $categories = [];
        foreach ($parents as $category) {
            $subs = $category->subcategories()->pluck('id')->toArray();
            $subs = Category::whereIn('id', array_unique($subs))->orderBy('label', 'asc')->get();
            $subcategories = [];
            foreach ($subs as $sub) {
                $value = ['label' => $sub->label, 'key' => $sub->title];
                if (!in_array($value, $subcategories)) {
                    $subcategories[] = $value;
                }
            }
            $value = ['label' => $category->label, 'key' => $category->title, 'subcategories' => $subcategories];
            if (!in_array($value, $categories)) {
                $categories[] = $value;
            }
        }
        Cache::forever('categories', $categories);
    }

    public function cacheRegions(){
        $groups = RegionGroup::all();
        $regions = [];
        foreach ($groups as $group) {
            $regions[] = ['regionGroup' => $group->title, 'regions' => $group->regions()->pluck('code')->toArray()];
        }
        Cache::forever('regions', $regions);
    }

    public function cacheTrialPeriod(){
        $trialPeriod = Setting::where('variable', 'trial_period')->first();
        Cache::forget('trialPeriod');
        Cache::forever('trialPeriod', $trialPeriod->value);
    }

    public function calculateMailDelay(){
        if(!Cache::has('emailsCount')){
            Cache::put('emailsCount', 1, Carbon::now()->setTimezone('Europe/Moscow')->startOfDay()->addDay());
        }else{
            Cache::increment('emailsCount');
        }
        if(!Cache::has('emailsHourCount')){
            Cache::put('emailsHourCount', 1, Carbon::now()->addHour());
        }else{
            Cache::increment('emailsHourCount');
        }
        $emailsCount = Cache::get('emailsCount');
        $emailsHourCount = Cache::get('emailsHourCount');
        $delay = null;
        if($emailsCount < 500) {
            $delay = 75 * $emailsHourCount;
        }
        return $delay;
    }

}
