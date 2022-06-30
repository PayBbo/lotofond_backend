<?php

namespace App\Http\Controllers;

use App\Http\Resources\BidderCollection;
use App\Http\Resources\TradePlaceCollection;
use App\Models\Bidder;
use App\Models\TradePlace;

class BidderController extends Controller
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

    public function getTradesBidder($bidderType, $bidderId){

    }

}
