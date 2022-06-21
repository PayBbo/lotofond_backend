<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\LotResource;
use App\Models\Auction;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function getTrades(){
        $lots = Lot::orderBy('created_at', 'DESC')->paginate(20);
        $data = [];
        foreach($lots as $lot){
            $data[] = new LotResource($lot);
        }
        return response($data, 200);
    }

    public function getTradesV2(){
        $lots = Lot::orderBy('created_at', 'DESC')->paginate(20);
        $data = [];
        foreach($lots as $lot){
            $data[] = new LotResource($lot);
        }
        $pagination = $lots;
        return response(['data'=>$data, 'pagination'=>$pagination], 200);
    }

    public function getLotsByAuction($auctionId){
        $auction = Auction::find($auctionId);
        if(!$auction){
            throw new BaseException("ERR_FIND_AUCTION_FAILED", 404, "Auction with id= ".$auctionId.' does not exist');
        }
        $data = [];
        foreach($auction->lots()->paginate(20) as $lot){
            $data[] = new LotResource($lot);
        }
        return response($data, 200);
    }

    public function getLotInformation($lotId){

        $lot = Lot::find($lotId);
        if(!$lot){
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= ".$lotId.' does not exist');
        }
        $lot->isLotInfo = true;
        return response(new LotResource($lot), 200);
    }

    public function actionWithLot(Request $request){
        $lot = Lot::find($request->lot_id);
        if(!$lot){
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= ".$request->lot_id.' does not exist');
        }
        $user = User::find(auth()->id());
        switch($request->type){
            case 'seen':{
                if($user->seenLots->contains($lot)){
                    $user->seenLots()->detach($lot);
                }else{
                    $user->seenLots()->attach($lot);
                }
                break;
            }
            case 'fixed':{
                if($user->fixedLots->contains($lot)){
                    $user->fixedLots()->detach($lot);
                }else{
                    $user->fixedLots()->attach($lot);
                }
            }
            case 'hidden':{
                if($user->hiddenLots->contains($lot)){
                    $user->hiddenLots()->detach($lot);
                }else{
                    $user->hiddenLots()->attach($lot);
                }
            }
        }

        return response(null, 200);
    }
}
