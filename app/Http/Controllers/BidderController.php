<?php

namespace App\Http\Controllers;

use App\Http\Resources\BidderCollection;
use App\Http\Resources\LotCollection;
use App\Http\Resources\TradePlaceCollection;
use App\Models\Bidder;
use App\Models\Lot;
use App\Models\TradePlace;

class BidderController extends Controller
{
    public function getTradesByBidder($type, $bidderType, $bidderId){
        $active_statuses = [1,2];
        if($bidderType == 'organizer'){
            $bidderType = 'companyTradeOrganizer';
        }
        if($type == 'active'){
            $lots = Lot::whereIn('status_id', $active_statuses)->whereHas('auction.'.$bidderType,
                function ($q) use ($bidderId) { $q->where('id', $bidderId);
            })->paginate(20);
        }else{
            $lots = Lot::whereNotIn('status_id', $active_statuses)->whereHas('auction.'.$bidderType,
                function ($q) use ($bidderId) { $q->where('id', $bidderId);
                })->paginate(20);
        }
        return response(new LotCollection($lots), 200);
    }

}
