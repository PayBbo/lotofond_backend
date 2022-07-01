<?php

namespace App\Http\Controllers;

use App\Http\Resources\BidderCollection;
use App\Http\Resources\TradePlaceCollection;
use App\Models\Bidder;
use App\Models\Category;
use App\Models\TradePlace;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function getBiddersForFilter($type)
    {
        $bidders = Bidder::has($type.'AuctionsWithLots')->whereHas('types', function ($query) use ($type) {
            $query->where('title', $type);
        })->paginate(20);
        return response(new BidderCollection($bidders), 200);
    }

    public function getTradePlacesForFilter(){

        $tradePlaces = TradePlace::has('auctionsWithLots')->get();
        return response(new TradePlaceCollection($tradePlaces), 200);

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
}
