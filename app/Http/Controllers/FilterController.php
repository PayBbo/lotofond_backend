<?php

namespace App\Http\Controllers;

use App\Http\Resources\BidderCollection;
use App\Http\Resources\TradePlaceResource;
use App\Models\Bidder;
use App\Models\Category;
use App\Models\Lot;
use App\Models\PriceReduction;
use App\Models\RegionGroup;
use App\Models\RegistryNotificationGroup;
use App\Models\TradePlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    public function getBiddersForFilter($type, Request $request)
    {
        $searchString = $request->searchString;
        $type = substr_replace($type, "", -1);
        $bidders = Bidder::has($type . 'AuctionsWithLots')->whereHas('types', function ($query) use ($type) {
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

        $tradePlaces = TradePlace::has('auctionsWithLots')->orderBy('name', 'asc')->get();
        return response(TradePlaceResource::collection($tradePlaces), 200);

    }

    public function getCategoriesForFilter()
    {

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
        return response($categories, 200);
    }

    public function getRegionsForFilter()
    {
        $groups = RegionGroup::all();
        $regions = [];
        foreach ($groups as $group) {
            $regions[] = ['regionGroup' => $group->title, 'regions' => $group->regions()->pluck('code')->toArray()];
        }
        return response($regions, 200);
    }

    public function getPricesForFilter()
    {
            \DB::statement("SET SQL_MODE=''");
            $data = [
                "currentPrice" => [
                    "min" => (float)PriceReduction::min('price'),
                    "max" => (float)PriceReduction::max('price'),
                ],
                "startPrice" => [
                    "min" => (float)Lot::min('start_price'),
                    "max" => (float)Lot::max('start_price'),
                ],
                "minPrice" => [
                    "min" => (float)Lot::with('priceReductions')
                        ->join('price_reductions as r', 'lots.id', '=', 'r.lot_id')
                        ->selectRaw('lots.*, MIN(r.price) as min_price')
                        ->groupBy('r.price')
                        ->orderBy('min_price', 'asc')
                        ->first()['min_price'],
                    "max" => (float)Lot::with('priceReductions')
                        ->join('price_reductions as r', 'lots.id', '=', 'r.lot_id')
                        ->selectRaw('lots.*, MIN(r.price) as min_price')
                        ->groupBy('r.price')
                        ->orderBy('min_price', 'desc')
                        ->first()['min_price'],
                ]
            ];
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
