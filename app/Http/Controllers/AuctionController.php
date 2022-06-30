<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\LotCollection;
use App\Http\Resources\LotResource;
use App\Http\Services\SortService;
use App\Http\Services\TradeFilterService;
use App\Models\Auction;
use App\Models\Lot;
use App\Models\PriceReduction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function getTrades(Request $request)
    {
        $lots = Lot::customSortBy($request)->paginate(20);
        return response(new LotCollection($lots), 200);
    }

    public function getFilteredTrades(Request $request)
    {
        $lots = Lot::filterBy($request->request)->customSortBy($request)->paginate(20);
        return response(new LotCollection($lots), 200);
    }


    public function getLotsByAuction(Request $request, $auctionId)
    {
        $auction = Auction::find($auctionId);
        if (!$auction) {
            throw new BaseException("ERR_FIND_AUCTION_FAILED", 404, "Auction with id= " . $auctionId . ' does not exist');
        }
        $lots = $auction->lots()->filterBy($request->request)->customSortBy($request)->paginate(20);
        return response(new LotCollection($lots), 200);
    }

    public function getLotInformation($lotId)
    {

        $lot = Lot::find($lotId);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $lotId . ' does not exist');
        }
        $lot->isLotInfo = true;
        return response(new LotResource($lot), 200);
    }

    public function actionWithLot(Request $request)
    {
        $lot = Lot::find($request->lot_id);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $request->lot_id . ' does not exist');
        }
        $user = User::find(auth()->id());
        switch ($request->type) {
            case 'seen':
            {
                if ($user->seenLots->contains($lot)) {
                    $user->seenLots()->detach($lot);
                } else {
                    $user->seenLots()->attach($lot);
                }
                break;
            }
            case 'fixed':
            {
                if ($user->fixedLots->contains($lot)) {
                    $user->fixedLots()->detach($lot);
                } else {
                    $user->fixedLots()->attach($lot);
                }
            }
            case 'hidden':
            {
                if ($user->hiddenLots->contains($lot)) {
                    $user->hiddenLots()->detach($lot);
                } else {
                    $user->hiddenLots()->attach($lot);
                }
            }
        }

        return response(null, 200);
    }

}
