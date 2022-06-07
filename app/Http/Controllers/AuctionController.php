<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\AuctionResource;
use App\Models\Lot;
use App\Models\User;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function getTrades(){
        $lots = Lot::orderBy('created_at', 'DESC')->paginate(20);
        $data = [];
        foreach($lots as $lot){
            $data[] = new AuctionResource($lot);
        }
        return response($data, 200);
    }

    public function monitoringLot($id){

    }
    public function favouriteLot($id){

    }
    public function actionWithLot(Request $request){
        $lot = Lot::find($request->lot_id);
        if(!$lot){
            throw new BaseException("ERR_FIND_LOT_FAILED", 422, "Lot with id= ".$request->lot_id/' does not exist');
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
