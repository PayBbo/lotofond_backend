<?php

namespace App\Http\Controllers;

use App\Http\Resources\BidderCollection;
use App\Http\Resources\TradePlaceResource;
use App\Models\Bidder;
use App\Models\Category;
use App\Models\Lot;
use App\Models\PriceReduction;
use App\Models\RegionGroup;
use App\Models\TradePlace;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function getBiddersForFilter($type, Request $request)
    {
        $searchString = $request->searchString;
        $type = substr_replace ($type, "", -1);
        $bidders = Bidder::has($type.'AuctionsWithLots')->whereHas('types', function ($query) use ($type) {
            $query->where('title', $type);
        })
            ->when(isset($searchString) && strlen($searchString) > 0, function($query) use ($searchString){
                $query->where('name', 'LIKE', '%' . $searchString . '%')
                    ->orWhere('short_name', 'LIKE', '%' . $searchString . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $searchString . '%')
                    ->orWhere('middle_name', 'LIKE', '%' . $searchString . '%');
            })
            ->paginate(20);
        return response(new BidderCollection($bidders), 200);
    }

    public function getTradePlacesForFilter(){

        $tradePlaces = TradePlace::has('auctionsWithLots')->get();
        return response(TradePlaceResource::collection($tradePlaces), 200);

    }

    public function getCategoriesForFilter(){

        $parents = Category::where('parent_id', null)->get();
        $categories = [];
        foreach ($parents as $category) {
            $subs = $category->subcategories()->pluck('id')->toArray();
            $subs = Category::whereIn('id', array_unique($subs))->get();
            $subcategories = [];
            foreach($subs as $sub){
                $value = ['label'=>$sub->label, 'key'=>$sub->title];
                if(!in_array($value, $subcategories)) {
                    $subcategories[] = $value;
                }
            }
            $value = ['label' => $category->label, 'key' => $category->title, 'subcategories' => $subcategories];
            if(!in_array($value, $categories)) {
                $categories[] = $value;
            }
        }
        return response($categories, 200);
    }

    public function getRegionsForFilter(){
        $groups = RegionGroup::all();
        $regions = [];
        foreach($groups as $group){
            $regions[] = ['regionGroup'=>$group->title, 'regions'=>$group->regions()->pluck('code')->toArray()];
        }
        return response($regions, 200);
    }

    public function getPricesForFilter(){
        $data = [
            "currentPrice"=>[
                "min"=> PriceReduction::min('price'),
                "max"=> PriceReduction::max('price'),
            ],
            "startPrice"=>[
                "min"=> (float)Lot::min('start_price'),
                "max"=> (float)Lot::max('start_price'),
            ],
            "minPrice"=>[
                "min"=> (float)Lot::addSelect(['minimum_price' => PriceReduction::select('price')
                    ->whereColumn('price_reductions.lot_id', 'lots.id')
                    ->orderBy('price', 'asc')
                    ->limit(1)])->get()->min('minimum_price'),
                "max"=> (float)Lot::addSelect(['minimum_price' => PriceReduction::select('price')
                    ->whereColumn('price_reductions.lot_id', 'lots.id')
                    ->orderBy('price', 'asc')
                    ->limit(1)])->get()->max('minimum_price'),
            ]
        ];
        return response($data, 200);
    }
}
