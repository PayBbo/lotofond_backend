<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\LotCollection;
use App\Http\Resources\LotResource;
use App\Http\Resources\LotShortCollection;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\VictoryCollection;
use App\Models\Auction;
use App\Models\BiddingResult;
use App\Models\FavouriteLot;
use App\Models\Lot;
use App\Models\Notification;
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
        $lots = Lot::customSortBy($request)->filterBy($request->request)->paginate(20);
        return response(new LotCollection($lots), 200);
    }

    public function getNearestTrades(Request $request)
    {
        $start = Carbon::now()->setTimezone('Europe/Moscow');
        $end = Carbon::now()->setTimezone('Europe/Moscow')->addWeek();
        $lots = Lot::customSortBy($request)->filterBy($request->request)
            ->whereHas('auction', function ($q) use ($start, $end) {
                $q->whereBetween('application_start_date', [$start, $end]);
            })->paginate(20);
        return response(new LotCollection($lots), 200);
    }

    public function getVictories()
    {
        $start = Carbon::now()->setTimezone('Europe/Moscow')->subWeek();
        $end = Carbon::now()->setTimezone('Europe/Moscow');
        $victories = BiddingResult::has('winner')->whereBetween('created_at', [$start, $end])->paginate(20);
        return response(new VictoryCollection($victories), 200);
    }

    public function getShortTrades(Request $request)
    {
        $searchString = $request->searchString;
        $lots = Lot::when(isset($searchString) && strlen((string)$searchString) > 0, function ($query) use ($searchString) {
            $query->whereHas('auction', function ($q) use ($searchString) {
                $q->where('trade_id', 'like', '%' . $searchString . '%');
            })
                ->orWhere('description', 'like', '%' . $searchString . '%');
        })->paginate(5);
        return response(new LotShortCollection($lots), 200);
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

    public function getLotNotifications($lotId)
    {
        $lot = Lot::find($lotId);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $lotId . ' does not exist');
        }
        $user = User::find(auth()->id());
        $favouriteLotIds = FavouriteLot::whereIn('favourite_id', $user->favourites->pluck('id'))->where('lot_id', $lotId)->get()->pluck('id');
        $notifications = Notification::whereIn('lot_id', $favouriteLotIds)
            ->where('user_id', auth()->id())->orderBy('date', 'DESC')->paginate(20);
        return response(new NotificationCollection($notifications), 200);

    }

    public function actionWithLot(Request $request)
    {
        $lot = null;
        if ($request->has('lotId')) {
            $lot = Lot::find($request->lotId);
            if (!$lot) {
                throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $request->lotId . ' does not exist');
            }
        }
        $auction = null;
        if ($request->has('auctionId')) {
            $auction = Auction::find($request->auctionId);
            if (!$auction) {
                throw new BaseException("ERR_FIND_AUCTION_FAILED", 404, "Auction with id= " . $request->auctionId . ' does not exist');
            }
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
                    $user->fixedLots()->attach($lot, ['created_at'=>Carbon::now()->setTimezone('Europe/Moscow')]);
                }
            }
            case 'hidden':
            {
                if ($lot) {
                    if ($user->hiddenLots->contains($lot)) {
                        $user->hiddenLots()->detach($lot);
                    } else {
                        $user->hiddenLots()->attach($lot);
                    }
                }
                if ($auction) {
                    foreach ($auction->lots as $lot) {
                        if ($user->hiddenLots->contains($lot)) {
                            $user->hiddenLots()->detach($lot);
                        } else {
                            $user->hiddenLots()->attach($lot);
                        }
                    }
                }
            }
        }

        return response(null, 200);
    }

}
