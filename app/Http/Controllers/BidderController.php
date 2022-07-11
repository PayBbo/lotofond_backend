<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\BidderResource;
use App\Http\Resources\LotCollection;
use App\Http\Resources\LotResource;
use App\Models\Bidder;
use App\Models\Lot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class BidderController extends Controller
{
    public function getTradesByBidder(Request $request){
        $active_statuses = [1,2];
        $bidderType = $request->bidderType;
        if($request->bidderType == 'organizer'){
            $bidderType = 'companyTradeOrganizer';
        }
        $bidderId = $request->bidderId;
        $exceptionLots = [];
        if($request->has('exceptionLotId')){
            $exceptionLots[] = $request->exceptionLotId;
        }
        if($request->type == 'active'){
            $lots = Lot::whereNotIn('id', $exceptionLots)->whereIn('status_id', $active_statuses)->whereHas('auction.'.$bidderType,
                function ($q) use ($bidderId) { $q->where('id', $bidderId);
            })->paginate(20);
        }else{
            $lots = Lot::whereNotIn('id', $exceptionLots)->whereNotIn('status_id', $active_statuses)->whereHas('auction.'.$bidderType,
                function ($q) use ($bidderId) { $q->where('id', $bidderId);
                })->paginate(20);
        }
        return response(LotResource::collection($lots), 200);
    }

    public function getBidder($bidderId){
        $bidder = Bidder::find($bidderId);
        if(!$bidder){
            throw new BaseException("ERR_FIND_BIDDER_FAILED", 404, "Bidder with id= " . $bidderId . ' does not exist');
        }
        return response(new BidderResource($bidder), 200);
    }

}
