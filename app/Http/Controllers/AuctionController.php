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
        $exceptionWords = null;
        $minDate = null;
        $maxDate = null;
        if (isset($request->dates)) {
            if (isset($request->dates['eventTimeStart'])) {
                if(isset($request->dates['eventTimeStart']['start']) && strlen((string) $request->dates['eventTimeStart']['start'])>0) {
                    $eventTimeStartMin = Carbon::parse($request->dates['eventTimeStart']['start']);
                }
                if(isset($request->dates['eventTimeStart']['end']) && strlen((string)$request->dates['eventTimeStart']['end'])>0) {
                    $eventTimeStartMax = Carbon::parse($request->dates['eventTimeStart']['end']);
                }
            }
            if (isset($request->dates['eventTimeEnd'])) {
                if(isset($request->dates['eventTimeEnd']['start']) && strlen((string)$request->dates['eventTimeEnd']['start'])>0) {
                    $eventTimeEndMin = Carbon::parse($request->dates['eventTimeEnd']['start']);
                }
                if(isset($request->dates['eventTimeEnd']['end']) && strlen((string)$request->dates['eventTimeEnd']['end'])>0) {
                    $eventTimeEndMax = Carbon::parse($request->dates['eventTimeEnd']['end']);
                }
            }
            if (isset($request->dates['applicationTimeStart'])) {
                if(isset($request->dates['applicationTimeStart']['start']) && strlen((string)$request->dates['applicationTimeStart']['start'])>0) {
                    $applicationTimeStartMin = Carbon::parse($request->dates['applicationTimeStart']['start']);
                }
                if(isset($request->dates['applicationTimeStart']['end']) && strlen((string)$request->dates['applicationTimeStart']['end'])>0) {
                    $applicationTimeStartMax = Carbon::parse($request->dates['applicationTimeStart']['end']);
                }
            }
            if (isset($request->dates['applicationTimeEnd'])) {
                if(isset($request->dates['applicationTimeEnd']['start']) && strlen((string)$request->dates['applicationTimeEnd']['start'])>0) {
                    $applicationTimeEndMin = Carbon::parse($request->dates['applicationTimeEnd']['start']);
                }
                if(isset($request->dates['applicationTimeEnd']['end']) && strlen((string)$request->dates['applicationTimeEnd']['end'])>0) {
                    $applicationTimeEndMax = Carbon::parse($request->dates['applicationTimeEnd']['end']);
                }
            }
        }
        if(isset($request->mainParams) && isset($request->mainParams['period']) && strlen((string)$request->mainParams['period']) >0 && $request->mainParams['period'] !== 'all'){
            $result = $this->getPeriodDates($request->mainParams['period']);
            $minDate = $result[0];
            $maxDate = $result[1];
        }
        if(isset($request->mainParams)){
            if(isset($request->mainParams['exceptionWords']) && strlen((string)$request->mainParams['exceptionWords'])>0){
                $exceptionWords = explode(',', $request->mainParams['exceptionWords']);
            }
        }
        $lots = Lot::when(isset($request->categories) && count($request->categories)>0, function ($query) use ($request) {
                return $query->whereHas('categories', function ($q) use ($request) {
                    $q->whereIn('title', $request->categories);
                });
            })
           /* ->when(isset($request->regions), function ($query) use ($request) {
                return $query->whereHas('auction.debtor.region', function ($q) use ($request) {
                    $q->whereIn('title', $request->regions);
                });
            })*/
            ->when(isset($request->prices) && isset($request->prices['startPrice'])
                   && strlen((string)$request->prices['startPrice']['min'])>0 && strlen((string)$request->prices['startPrice']['max'])>0, function ($query) use ($request) {
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
            ->when(isset($request->extraOptions) && isset($request->extraOptions['debtorCategories']) && count($request->extraOptions['debtorCategories'])>0, function ($query) use ($request) {
                return $query->whereHas('auction.debtor.debtorCategory', function ($q) use ($request) {
                    $q->whereIn('code', $request->extraOptions['debtorCategories']);
                });
            })
            ->when(isset($request->extraOptions) && isset($request->extraOptions['debtors']) && count($request->extraOptions['debtors'])>0, function ($query) use ($request) {
                return $query->whereHas('auction.debtor', function ($q) use ($request) {
                    $q->whereIn('id', $request->extraOptions['debtors']);
                });
            })
            ->when(isset($request->extraOptions) && isset($request->extraOptions['organizers']) && count($request->extraOptions['organizers'])>0, function ($query) use ($request) {
                return $query->whereHas('auction.companyTradeOrganizer', function ($q) use ($request) {
                    $q->whereIn('id', $request->extraOptions['organizers']);
                });
            })
            ->when(isset($request->extraOptions) && isset($request->extraOptions['arbitrManagers']) && count($request->extraOptions['arbitrManagers'])>0, function ($query) use ($request) {
                return $query->whereHas('auction.arbitrManager', function ($q) use ($request) {
                    $q->whereIn('id', $request->extraOptions['arbitrManagers']);
                });
            })
            ->when(isset($exceptionWords), function($query) use ($exceptionWords) {
                foreach($exceptionWords as $word){
                    $query->where('description', 'NOT LIKE', '%'.$word.'%');
                }
            })
            ->when(isset($request->mainParams) && isset($request->mainParams['tradePlaces']) && count($request->mainParams['tradePlaces'])>0, function ($query) use ($request) {
                return $query->whereHas('auction', function ($q) use ($request) {
                    $q->whereIn('trade_place_id', $request->mainParams['tradePlaces']);
                });
            })
            ->when(isset($request->mainParams) && isset($request->mainParams['tradeNumber']) && strlen((string)$request->mainParams['tradeNumber'])>0, function ($query) use ($request) {
                return $query->whereHas('auction', function ($q) use ($request) {
                    $q->where('trade_id', $request->mainParams['tradeNumber']);
                });
            })
            ->when(isset($request->mainParams) && isset($request->mainParams['tradeType']) && strlen((string)$request->mainParams['tradeType'])>0, function ($query) use ($request) {
                return $query->whereHas('auction.auctionType', function ($q) use ($request) {
                    $q->where('title', $request->mainParams['tradeType']);
                });
            })
            ->when(isset($request->mainParams) && isset($request->mainParams['isWithPhotos']) && $request->mainParams['isWithPhotos']===true, function($query) use ($request){
                $query->where('photos', 'IS NOT', null);
            })
            ->when(isset($request->mainParams) && isset($request->mainParams['isStopped']) && $request->mainParams['isStopped'] === true, function($query) use ($request){
                return $query->whereHas('status', function ($q) use ($request) {
                    $q->where('id', 10);
                });
            })
            ->when(isset($request->mainParams) && isset($request->mainParams['isCompleted']) && $request->mainParams['isCompleted'] === true, function($query) use ($request){
                return $query->whereHas('status', function ($q) use ($request) {
                    $q->where('id', 6);
                });
            })

            ->when(isset($request->mainParams) && isset($request->mainParams['isDeleted']) && $request->mainParams['isDeleted'] === true, function($query) use ($request){
                return $query->whereHas('status', function ($q) use ($request) {
                    $q->where('id', 8);
                });
            })

            ->when(isset($minDate) && isset($maxDate), function ($query)
            use ($minDate, $maxDate) {
                return $query->whereHas('auction', function ($q) use ($minDate, $maxDate) {
                    $q->whereBetween('publish_date',
                        [$minDate, $maxDate]);
                });
            })

            ->latest()
            ->paginate(20);

        return response(new LotCollection($lots), 200);
    }

    public function getPeriodDates($period){
        $result = [];
        switch($period){
            case '1 day':{
                $result[0]=Carbon::now()->setTimezone('Europe/Moscow')->startOfDay();
                break;
            }
            case '7 days':{
                $result[0]=Carbon::now()->setTimezone('Europe/Moscow')->startOfDay()->subWeek();
                break;
            }
            case '30 days':{
                $result[0]=Carbon::now()->setTimezone('Europe/Moscow')->startOfDay()->subDays(30);
                break;
            }
        }
        $result[1]=Carbon::now()->setTimezone('Europe/Moscow')->endOfDay();
        return $result;
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
