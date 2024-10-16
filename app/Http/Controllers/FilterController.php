<?php

namespace App\Http\Controllers;

use App\Http\Resources\BidderCollection;
use App\Http\Resources\TradePlaceResource;
use App\Http\Services\CacheService;
use App\Models\Bidder;
use App\Models\RegistryNotificationGroup;
use App\Models\TradePlaceCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class FilterController extends Controller
{
    public function getBiddersForFilter($type, Request $request)
    {
        $searchString = $request->searchString;
        $type = substr_replace($type, "", -1);
        $bidders = Bidder::hasByNonDependentSubquery($type . 'AuctionsWithLots')
            ->with('region')
            ->hasByNonDependentSubquery('types', function ($query) use ($type) {
            $query->where('title', $type);
        })
            ->when(isset($searchString) && strlen($searchString) > 0, function ($query) use ($searchString) {
                $query->where('name', 'LIKE', '%' . $searchString . '%')
                    ->orWhere('short_name', 'LIKE', '%' . $searchString . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $searchString . '%')
                    ->orWhere('middle_name', 'LIKE', '%' . $searchString . '%');
            })
            ->paginate(20);
        return response(new BidderCollection($bidders), 200);
    }

    public function getTradePlacesForFilter()
    {
        if (!Cache::has('tradePlaces')) {
            $cacheService = new CacheService();
            $cacheService->cacheTradePlacesForFilter();
        }
        $tradePlaces = Cache::get('tradePlaces');
        return response(TradePlaceResource::collection($tradePlaces), 200);

    }

    public function getTradePlacesForFilterV1()
    {
        $cachedTradePlaces = Cache::get('tradePlacesV1');
        if (isset($cachedTradePlaces)) {
            $tradePlaces = $cachedTradePlaces;
        } else {
            $tradePlaceCategories = TradePlaceCategory::all();
            $tradePlaces = [];
            foreach($tradePlaceCategories as $tradePlaceCategory){
                $groupedTradePlaces = $tradePlaceCategory->tradePlaces()->select('id', 'name')->orderBy('name', 'asc')->get();
                $tradePlaces[] = ['category'=>$tradePlaceCategory->title, 'tradePlaces'=>$groupedTradePlaces];
            }
            Cache::put('tradePlacesV1', $tradePlaces, Carbon::now()->setTimezone('Europe/Moscow')->addHour());
        }
        return response($tradePlaces, 200);

    }

    public function getCategoriesForFilter()
    {
        if (!Cache::has('categories') || request()->get('recache',false)) {
            $cacheService = new CacheService();
            $cacheService->cacheCategories();
        }
        $categories = Cache::get('categories');

        return response($categories, 200);
    }

    public function getRegionsForFilter()
    {
        if (!Cache::has('regions')) {
            $cacheService = new CacheService();
            $cacheService->cacheRegions();
        }
        $regions = Cache::get('regions');
        return response($regions, 200);
    }

    public function getPricesForFilter()
    {
        if (!Cache::has('prices')) {
            $cacheService = new CacheService();
            $cacheService->cachePricesForFilter();
        }
        $data = Cache::get('prices');
        return response($data, 200);
    }

    public function getRegistryTypesForFilter()
    {
        $groups = RegistryNotificationGroup::all();
        $messagesTypes = [];
        foreach ($groups as $group) {
            $types = [];
            foreach ($group->registryNotificationTypes as $type) {
                $types[] = ['code' => $type->title, 'title' => __('registry_notifications.' . $type->title)];
            }
            $messagesTypes[] = [
                'messagesGroup' => __('registry_notifications.' . $group->title),
                'types' => $types
            ];
        }
        return response($messagesTypes, 200);
    }
}
