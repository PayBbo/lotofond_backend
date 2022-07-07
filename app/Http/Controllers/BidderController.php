<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\BidderResource;
use App\Http\Resources\LotCollection;
use App\Models\Bidder;
use App\Models\Lot;

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

    public function getBidder($bidderId){
        $bidder = Bidder::find($bidderId);
        if(!$bidder){
            throw new BaseException("ERR_FIND_BIDDER_FAILED", 404, "Bidder with id= " . $bidderId . ' does not exist');
        }
        return response(new BidderResource($bidder), 200);
    }

}
