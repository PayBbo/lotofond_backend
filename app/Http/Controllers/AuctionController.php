<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Resources\LotCollection;
use App\Http\Resources\LotResource;
use App\Models\Auction;
use App\Models\Lot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function getTrades()
    {
        $lots = Lot::orderBy('created_at', 'DESC')->paginate(20);
        return response(new LotCollection($lots), 200);
    }

    public function getFilteredTrades(Request $request)
    {
        $eventTimeStartMin = null;
        $eventTimeStartMax = null;
        $eventTimeEndMin = null;
        $eventTimeEndMax = null;
        $applicationTimeStartMin = null;
        $applicationTimeStartMax = null;
        $applicationTimeEndMin = null;
        $applicationTimeEndMax = null;
        if (!is_null($request->dates)) {
            if (isset($request->dates['eventTimeStart'])) {
                $eventTimeStartMin = Carbon::parse($request->dates['eventTimeStart']['start']);
                $eventTimeStartMax = Carbon::parse($request->dates['eventTimeStart']['end']);
            }
            if (isset($request->dates['eventTimeEnd'])) {
                $eventTimeEndMin = Carbon::parse($request->dates['eventTimeEnd']['start']);
                $eventTimeEndMax = Carbon::parse($request->dates['eventTimeEnd']['end']);
            }
            if (isset($request->dates['applicationTimeStart'])) {
                $applicationTimeStartMin = Carbon::parse($request->dates['applicationTimeStart']['start']);
                $applicationTimeStartMax = Carbon::parse($request->dates['applicationTimeStart']['end']);
            }
            if (isset($request->dates['applicationTimeEnd'])) {
                $applicationTimeEndMin = Carbon::parse($request->dates['applicationTimeEnd']['start']);
                $applicationTimeEndMax = Carbon::parse($request->dates['applicationTimeEnd']['end']);
            }
        }
        $lots = Lot::with(['auction', 'categories'])
            ->when(isset($request->categories), function ($query) use ($request) {
                return $query->whereHas('categories', function ($q) use ($request) {
                    $q->whereIn('title', $request->categories);
                });
            })
            ->when(isset($request->regions), function ($query) use ($request) {
                return $query->whereHas('auction.debtor.region', function ($q) use ($request) {
                    $q->whereIn('title', $request->regions);
                });
            })
            ->when(isset($request->prices) && isset($request->prices['startPrice']), function ($query) use ($request) {
                $query->whereBetween('start_price',
                    [$request->prices['startPrice']['min'], $request->prices['startPrice']['max']]);
            })
              /*->when(isset($request->prices) && isset($request->prices['currentPrice']), function ($query) use ($request) {
                  if( $query->first()) {
                      if($query->first()->getCurrentPriceAttribute() > $request->prices['currentPrice']['min']
                      && $query->first()->getCurrentPriceAttribute() < $request->prices['currentPrice']['max']){
                          return $query;
                      }
                  }
              })

              ->when(isset($request->prices) && isset($request->prices['minPrice']), function ($query) use ($request) {
                  if($query->first()) {
                    $query->first()->getMinPriceAttribute() > $request->prices['minPrice']['min']
                      && $query->first()->getMinPriceAttribute() < $request->prices['minPrice']['max'];
                  }
              })*/

            ->when(isset($eventTimeStartMin) && isset($eventTimeStartMax), function ($query)
            use ($eventTimeStartMin, $eventTimeStartMax) {
                return $query->whereHas('auction', function ($q) use ($eventTimeStartMin, $eventTimeStartMax) {
                    $q->whereBetween('event_start_date',
                        [$eventTimeStartMin, $eventTimeStartMax]);
                });
            })
            ->when(isset($eventTimeEndMin) && isset($eventTimeEndMax), function ($query)
            use ($eventTimeEndMin, $eventTimeEndMax) {
                return $query->whereHas('auction', function ($q) use ($eventTimeEndMin, $eventTimeEndMax) {
                    $q->whereBetween('event_end_date',
                        [$eventTimeEndMin, $eventTimeEndMax]);
                });
            })
            ->when(isset($applicationTimeStartMin) && isset($applicationTimeStartMax), function ($query)
            use ($applicationTimeStartMin, $applicationTimeStartMax) {
                return $query->whereHas('auction', function ($q) use ($applicationTimeStartMin, $applicationTimeStartMax) {
                    $q->whereBetween('application_start_date',
                        [$applicationTimeStartMin, $applicationTimeStartMax]);
                });
            })
            ->when(isset($applicationTimeEndMin) && isset($applicationTimeEndMax), function ($query)
            use ($applicationTimeEndMin, $applicationTimeEndMax) {
                return $query->whereHas('auction', function ($q) use ($applicationTimeEndMin, $applicationTimeEndMax) {
                    $q->whereBetween('application_start_date',
                        [$applicationTimeEndMin, $applicationTimeEndMax]);
                });
            })
            ->when(isset($request->extraOptions) && isset($request->extraOptions['debtorCategories']), function ($query) use ($request) {
                return $query->whereHas('auction.debtor.debtorCategory', function ($q) use ($request) {
                    $q->whereIn('code', $request->extraOptions['debtorCategories']);
                });
            })
            ->when(isset($request->extraOptions) && isset($request->extraOptions['debtors']), function ($query) use ($request) {
                return $query->whereHas('auction.debtor', function ($q) use ($request) {
                    $q->whereIn('id', $request->extraOptions['debtors']);
                });
            })
            ->when(isset($request->extraOptions) && isset($request->extraOptions['organizers']), function ($query) use ($request) {
                return $query->whereHas('auction.companyTradeOrganizer', function ($q) use ($request) {
                    $q->whereIn('id', $request->extraOptions['organizers']);
                });
            })
            ->when(isset($request->extraOptions) && isset($request->extraOptions['arbitrManagers']), function ($query) use ($request) {
                return $query->whereHas('auction.arbitrManager', function ($q) use ($request) {
                    $q->whereIn('id', $request->extraOptions['arbitrManagers']);
                });
            })
            ->latest()
            ->paginate(20);

        return response(new LotCollection($lots), 200);
    }

    public function getLotsByAuction($auctionId)
    {
        $auction = Auction::find($auctionId);
        if (!$auction) {
            throw new BaseException("ERR_FIND_AUCTION_FAILED", 404, "Auction with id= " . $auctionId . ' does not exist');
        }
        $lots = $auction->lots()->paginate(20);
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
