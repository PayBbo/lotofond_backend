<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\LotCollection;
use App\Http\Resources\LotResource;
use App\Http\Resources\LotShortCollection;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\VictoryCollection;
use App\Jobs\ClearHiddenLotsJob;
use App\Models\Auction;
use App\Models\BiddingResult;
use App\Models\Favourite;
use App\Models\FavouriteLot;
use App\Models\Lot;
use App\Models\Monitoring;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller
{
    public function getTrades(Request $request)
    {
        $lots = Lot::doesntHave('userHiddenLot')->customSortBy($request)->paginate(20);
        return response(new LotCollection($lots), 200);
    }

    public function getFilteredTrades(Request $request)
    {
        if (auth()->check()) {
            $lots = Lot::customSortBy($request)->filterBy($request->request)->paginate(20);
            return response(new LotCollection($lots), 200);
        } else {
            $lots = Lot::customSortBy($request)->filterBy($request->request)->limit(5)->get();
            return response([
                'data' => LotResource::collection($lots),
                'pagination' => [
                    'total' => 5,
                    'count' => 5,
                    'perPage' => 5,
                    'currentPage' => 1,
                    'lastPage' => 1,
                    'from' => 1,
                    'nextPageUrl' => null,
                    'to' => 5,
                    'prevPageUrl' => null
                ]], 200);
        }
    }

    public function getNearestTrades(Request $request)
    {
        $start = Carbon::now()->setTimezone('Europe/Moscow');
        $end = Carbon::now()->setTimezone('Europe/Moscow')->addWeek();
        if (auth()->check()) {
            $lots = Lot::customSortBy($request)->filterBy($request->request)
                ->whereHas('auction', function ($q) use ($start, $end) {
                    $q->whereBetween('application_start_date', [$start, $end])
                        ->where('application_end_date', '>', $end);
                })->paginate(20);
            return response(new LotCollection($lots), 200);
        } else {
            $lots = Lot::customSortBy($request)->filterBy($request->request)
                ->whereHas('auction', function ($q) use ($start, $end) {
                    $q->whereBetween('application_start_date', [$start, $end])
                        ->where('application_end_date', '>', $end);
                })->limit(5)->get();
            return response([
                'data' => LotResource::collection($lots),
                'pagination' => [
                    'total' => 5,
                    'count' => 5,
                    'perPage' => 5,
                    'currentPage' => 1,
                    'lastPage' => 1,
                    'from' => 1,
                    'nextPageUrl' => null,
                    'to' => 5,
                    'prevPageUrl' => null
                ]], 200);
        }
    }

    public function getVictories()
    {
        $start = Carbon::now()->setTimezone('Europe/Moscow')->subWeek();
        $end = Carbon::now()->setTimezone('Europe/Moscow');
        $victories = BiddingResult::has('winner')->whereBetween('created_at', [$start, $end])
            ->whereHas('tradeMessage.lot', function ($query) {
                $query->whereBetween(DB::raw('(start_price/end_price)*100-100'), [-15, 35]);
            })->paginate(20);
        return response(new VictoryCollection($victories), 200);
    }

    public function getShortTrades(Request $request)
    {
        $searchString = $request->searchString;
        $lots = Lot::doesntHave('userHiddenLot')->when(isset($searchString) && strlen((string)$searchString) > 0, function ($query) use ($searchString) {
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
            throw new BaseException("ERR_FIND_TRADE_FAILED", 404, "Trade with id= " . $auctionId . ' does not exist');
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

    public function getShortLotInformation($lotId){
        $lot = Lot::find($lotId);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $lotId . ' does not exist');
        }
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

    public function toggleSeen($lotId)
    {
        $lot = Lot::find($lotId);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $lotId . ' does not exist');
        }
        $user = User::find(auth()->id());
        if ($user->seenLots->contains($lot)) {
            $user->seenLots()->detach($lot);
        } else {
            $user->seenLots()->attach($lot);
        }
        return response(null, 200);
    }

    public function toggleHide($lotId)
    {
        $lot = Lot::find($lotId);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $lotId . ' does not exist');
        }
        $user = User::find(auth()->id());
        $lots = [];
        if ($user->hiddenLots->contains($lot)) {
            $user->hiddenLots()->detach($lot);
        } else {
            $lots[] = $lot;
            dispatch(new ClearHiddenLotsJob($user, $lots));
        }
        return response(null, 200);
    }

    public function togglePin($lotId)
    {
        $lot = Lot::find($lotId);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $lotId . ' does not exist');
        }
        $user = User::find(auth()->id());
        if ($user->fixedLots->contains($lot)) {
            $user->fixedLots()->detach($lot);
        } else {
            $user->fixedLots()->attach($lot, ['created_at' => Carbon::now()->setTimezone('Europe/Moscow')]);
        }
        return response(null, 200);
    }

    public function makeHiddenLotByTrade($tradeId)
    {
        $auction = Auction::find($tradeId);
        if (!$auction) {
            throw new BaseException("ERR_FIND_TRADE_FAILED", 404, "Trade with id= " . $tradeId . ' does not exist');
        }
        $user = User::find(auth()->id());
        $result = $auction->lots()->pluck('id');
        dispatch(new ClearHiddenLotsJob($user, $auction->lots));
        return response()->json(['lotIds' => $result], 200);
    }

    public function deleteHiddenLotByTrade($tradeId)
    {
        $auction = Auction::find($tradeId);
        if (!$auction) {
            throw new BaseException("ERR_FIND_TRADE_FAILED", 404, "Trade with id= " . $tradeId . ' does not exist');
        }
        $user = User::find(auth()->id());
        $result = [];
        foreach ($auction->lots as $lot) {
            if ($user->hiddenLots->contains($lot)) {
                $user->hiddenLots()->detach($lot);
            }
            $result[] = $lot->id;
        }
        return response()->json(['lotIds' => $result], 200);
    }


}
