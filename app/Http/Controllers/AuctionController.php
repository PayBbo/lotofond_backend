<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\LotCollection;
use App\Http\Resources\LotResource;
use App\Http\Resources\LotShortCollection;
use App\Http\Resources\LotShortResource;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\VictoryCollection;
use App\Http\Services\ContentSettingsService;
use App\Jobs\ClearHiddenLotsJob;
use App\Models\Auction;
use App\Models\BiddingResult;
use App\Models\ContentRule;
use App\Models\Favourite;
use App\Models\FavouriteLot;
use App\Models\Lot;
use App\Models\Monitoring;
use App\Models\Notification;
use App\Models\User;
use App\Traits\TorgiGovRuTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller
{
    use TorgiGovRuTrait;

    protected $numberOfLotsForUnauthorizedUsers;

    public function __construct()
    {
        $this->numberOfLotsForUnauthorizedUsers = config('auth.numberOfLotsForUnauthorizedUsers');
    }

    public function getTrades(Request $request)
    {
        $userId = auth()->id();
        $lots = Lot::with(['auction', 'showRegions', 'status', 'lotImages', 'categories', 'lotParams'])
            ->when($userId, function ($query) use ($userId) {
                $query->whereDoesntHave("hiddenLots",  function ($subQuery) use ($userId) {
                    $subQuery->where("user_id", "=", $userId);
                });
            })
            ->where('active', true)
            ->customSortBy($request)->paginate(20);
        return response(new LotCollection($lots), 200);
    }

    public function getFilteredTrades(Request $request)
    {
        try {
            $authCheck = auth()->guard('api')->check();
            if ($authCheck) {
                $lots = Lot::with(['auction', 'showRegions', 'status', 'lotImages', 'categories', 'lotParams'])
                    ->where('active', true)
                    ->filterBy($request->request)->customSortBy($request)->paginate(20);
                return response(new LotCollection($lots), 200);
            } else {
                $lots = Lot::with(['auction', 'showRegions', 'status', 'lotImages', 'categories', 'lotParams'])
                    ->filterBy($request->request)->customSortBy($request)
                    ->limit($this->numberOfLotsForUnauthorizedUsers)->get();
                return response(new LotCollection($lots), 200);
            }
        }
        catch (\Exception $e) {
            return response()->json(['message'=> $e->getMessage()], 500);
        }

    }

    public function getNearestTrades(Request $request)
    {
        $start = Carbon::now()->setTimezone('Europe/Moscow');
        $end = Carbon::now()->setTimezone('Europe/Moscow')->addWeek();
        $authCheck = auth()->guard('api')->check();
        if ($authCheck) {
            $lots = Lot::with(['auction', 'showRegions', 'status', 'lotImages', 'categories', 'lotParams'])
                ->where('active', true)
                ->filterBy($request->request)
                ->hasByNonDependentSubquery('auction', function ($q) use ($start, $end) {
                    $q->whereBetween('application_start_date', [$start, $end])
                        ->where('application_end_date', '>', $end);
                })->customSortBy($request)->paginate(20);
            return response(new LotCollection($lots), 200);
        } else {
            $lots = Lot::with(['auction', 'showRegions', 'status', 'lotImages', 'categories', 'lotParams'])
                ->where('active', true)
                ->filterBy($request->request)
                ->whereHas('auction', function ($q) use ($start, $end) {
                    $q->whereBetween('application_start_date', [$start, $end])
                        ->where('application_end_date', '>', $end);
                })->customSortBy($request)
                ->limit($this->numberOfLotsForUnauthorizedUsers)->get();
            return response(new LotCollection($lots), 200);
        }
    }

    public function getVictories()
    {
        $start = Carbon::now()->setTimezone('Europe/Moscow')->subWeek();
        $end = Carbon::now()->setTimezone('Europe/Moscow');
        $victories = BiddingResult::has('winner')->whereBetween('created_at', [$start, $end])
            ->whereHas('tradeMessage.lot', function ($query) {
                $query->whereBetween(DB::raw('(end_price - start_price)/start_price*100'), [0, 15])
                    ->orWhere(function ($query) {
                        $query->whereBetween(DB::raw('(start_price - end_price)/start_price*100'), [50, 100]);
                    });
            })->paginate(20);
        return response(new VictoryCollection($victories), 200);
    }

    public function getShortTrades(Request $request)
    {
        $searchString = $request->searchString;
        $lots = Lot::with(['auction', 'lotImages', 'categories'])
            ->where('active', true)
            ->when(auth()->guard('api')->check(), function ($query) {
                $query->whereNotIn('lots.id', auth()->guard('api')->user()->hiddenLots->pluck('id'));
            })
            ->when(isset($searchString) && strlen((string)$searchString) > 0, function ($query) use ($searchString) {
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
        $lots = $auction->lots()->with(['auction', 'showRegions', 'status', 'lotImages', 'categories', 'lotParams'])
            ->filterBy($request->request)->customSortBy($request)->paginate(20);
        return response(new LotCollection($lots), 200);
    }

    public function getLotInformation($lotId)
    {
        $lot = Lot::find($lotId);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $lotId . ' does not exist');
        }
        $lot->isLotInfo = true;
        $data = null;
        $authCheck = auth()->guard('api')->check();
        $settingsService = new ContentSettingsService();
        if ($authCheck) {
            $data = $settingsService->getUserData();
        }
        return response((new LotResource($lot))->content($settingsService, $authCheck, $data), 200);
    }

    public function getShortLotInformation($lotId)
    {
        $lot = Lot::find($lotId);
        if (!$lot) {
            throw new BaseException("ERR_FIND_LOT_FAILED", 404, "Lot with id= " . $lotId . ' does not exist');
        }
        $settingsService = new ContentSettingsService();
        return response((new LotShortResource($lot))->contentRules($settingsService), 200);
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
            dispatch((new ClearHiddenLotsJob($user, $lots))->onQueue('user'));
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
        dispatch((new ClearHiddenLotsJob($user, $auction->lots))->onQueue('user'));
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
