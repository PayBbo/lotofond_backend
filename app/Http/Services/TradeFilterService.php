<?php

namespace App\Http\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TradeFilterService
{

    public function filterTrades(Request $request, $lots)
    {
        $eventTimeStartMin = null;
        $eventTimeStartMax = null;
        $eventTimeEndMin = null;
        $eventTimeEndMax = null;
        $applicationTimeStartMin = null;
        $applicationTimeStartMax = null;
        $applicationTimeEndMin = null;
        $applicationTimeEndMax = null;
        $excludedWords = null;
        $includedWords = null;
        $minDate = null;
        $maxDate = null;
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');
        if (isset($request->dates)) {
            if (isset($request->dates['eventTimeStart'])) {
                if (isset($request->dates['eventTimeStart']['start']) && strlen((string)$request->dates['eventTimeStart']['start']) > 0) {
                    $eventTimeStartMin = Carbon::parse($request->dates['eventTimeStart']['start']);
                }
                if (isset($request->dates['eventTimeStart']['end']) && strlen((string)$request->dates['eventTimeStart']['end']) > 0) {
                    $eventTimeStartMax = Carbon::parse($request->dates['eventTimeStart']['end']);
                }
            }
            if (isset($request->dates['eventTimeEnd'])) {
                if (isset($request->dates['eventTimeEnd']['start']) && strlen((string)$request->dates['eventTimeEnd']['start']) > 0) {
                    $eventTimeEndMin = Carbon::parse($request->dates['eventTimeEnd']['start']);
                }
                if (isset($request->dates['eventTimeEnd']['end']) && strlen((string)$request->dates['eventTimeEnd']['end']) > 0) {
                    $eventTimeEndMax = Carbon::parse($request->dates['eventTimeEnd']['end']);
                }
            }
            if (isset($request->dates['applicationTimeStart'])) {
                if (isset($request->dates['applicationTimeStart']['start']) && strlen((string)$request->dates['applicationTimeStart']['start']) > 0) {
                    $applicationTimeStartMin = Carbon::parse($request->dates['applicationTimeStart']['start']);
                }
                if (isset($request->dates['applicationTimeStart']['end']) && strlen((string)$request->dates['applicationTimeStart']['end']) > 0) {
                    $applicationTimeStartMax = Carbon::parse($request->dates['applicationTimeStart']['end']);
                }
            }
            if (isset($request->dates['applicationTimeEnd'])) {
                if (isset($request->dates['applicationTimeEnd']['start']) && strlen((string)$request->dates['applicationTimeEnd']['start']) > 0) {
                    $applicationTimeEndMin = Carbon::parse($request->dates['applicationTimeEnd']['start']);
                }
                if (isset($request->dates['applicationTimeEnd']['end']) && strlen((string)$request->dates['applicationTimeEnd']['end']) > 0) {
                    $applicationTimeEndMax = Carbon::parse($request->dates['applicationTimeEnd']['end']);
                }
            }
        }
        if (isset($request->other) && isset($request->other['period']) && strlen((string)$request->other['period']) > 0 && $request->other['period'] !== 'all') {
            $result = $this->getPeriodDates($request->other['period']);
            $minDate = $result[0];
            $maxDate = $result[1];
        }
        if (isset($request->mainParams)) {
            if (isset($request->mainParams['excludedWords']) && strlen((string)$request->mainParams['excludedWords']) > 0) {
                $excludedWords = explode(',', $request->mainParams['excludedWords']);
            }
            if (isset($request->mainParams['includedWords']) && strlen((string)$request->mainParams['includedWords']) > 0) {
                $includedWords = explode(',', $request->mainParams['includedWords']);
            }
        }
        return $lots
            /*->when(isset($request->categories) && count($request->categories) > 0, function ($query) use ($request) {
            return $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('title', $request->categories);
            });
        })*/
           /* ->when(isset($request->regions), function ($query) use ($request) {
                return $query->whereHas('auction.debtor.region', function ($q) use ($request) {
                    $q->whereIn('title', $request->regions);
                });
            })*/
            ->when(isset($request->prices) && isset($request->prices['startPrice'])
                && strlen((string)$request->prices['startPrice']['min']) > 0 && strlen((string)$request->prices['startPrice']['max']) > 0, function ($query) use ($request) {
                $query->whereBetween('start_price',
                    [$request->prices['startPrice']['min'], $request->prices['startPrice']['max']]);
            })
            ->when(isset($request->prices) && isset($request->prices['currentPrice'])
                && strlen((string)$request->prices['currentPrice']['min']) > 0 && strlen((string)$request->prices['currentPrice']['max']) > 0, function ($query) use ($request, $currentDate) {
                return $query
                    ->whereHas('priceReductions', function ($q) use ($request, $currentDate) {
                        $q->whereDate('start_time', '<=', $currentDate)->
                        whereDate('end_time', '>', $currentDate)->whereBetween('price',
                            [$request->prices['currentPrice']['min'], $request->prices['currentPrice']['max']]);
                    });
            })
            ->when(isset($request->prices) && isset($request->prices['minPrice'])
                && strlen((string)$request->prices['minPrice']['min']) > 0 && strlen((string)$request->prices['minPrice']['max']) > 0, function ($query) use ($request) {
                    return $query->whereHas('priceReductionsMin', function ($q) use ($request) {
                        $q->whereBetween('price',
                            [(float)$request->prices['minPrice']['min'], (float)$request->prices['minPrice']['max']]);
                    });

            })
            ->when(isset($request->prices) && isset($request->prices['percentageReduction'])
                && strlen((string)$request->prices['percentageReduction']['min']) > 0 && strlen((string)$request->prices['percentageReduction']['max']) > 0, function ($query) use ($request, $currentDate) {
                return $query->whereHas('priceReductions', function ($q) use ($request, $currentDate) {
                    $q->whereDate('start_time', '<=', $currentDate)->
                    whereDate('end_time', '>', $currentDate)->whereBetween('percent',
                        [$request->prices['percentageReduction']['min'], $request->prices['percentageReduction']['max']]);
                });
            })
        /*    ->when(isset($eventTimeStartMin) && isset($eventTimeStartMax), function ($query)
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
            })*/
            /*->when(isset($request->extraOptions) && isset($request->extraOptions['debtorCategories']) && count($request->extraOptions['debtorCategories']) > 0, function ($query) use ($request) {
                return $query->whereHas('auction.debtor.debtorCategory', function ($q) use ($request) {
                    $q->whereIn('code', $request->extraOptions['debtorCategories']);
                });
            })*/
           /* ->when(isset($request->extraOptions) && isset($request->extraOptions['debtors']) && count($request->extraOptions['debtors']) > 0, function ($query) use ($request) {
                return $query->whereHas('auction.debtor', function ($q) use ($request) {
                    $q->whereIn('id', $request->extraOptions['debtors']);
                });
            })
            ->when(isset($request->extraOptions) && isset($request->extraOptions['organizers']) && count($request->extraOptions['organizers']) > 0, function ($query) use ($request) {
                return $query->whereHas('auction.companyTradeOrganizer', function ($q) use ($request) {
                    $q->whereIn('id', $request->extraOptions['organizers']);
                });
            })*/
          /*  ->when(isset($request->extraOptions) && isset($request->extraOptions['arbitrManagers']) && count($request->extraOptions['arbitrManagers']) > 0, function ($query) use ($request) {
                return $query->whereHas('auction.arbitrManager', function ($q) use ($request) {
                    $q->whereIn('id', $request->extraOptions['arbitrManagers']);
                });
            })*/
        /*    ->when(isset($excludedWords), function ($query) use ($excludedWords) {
                foreach ($excludedWords as $word) {
                    $query->where('description', 'NOT LIKE', '%' . $word . '%')
                        ->orWhereHas('auction', function ($q) use ($word) {
                            $q->where('trade_id', 'NOT LIKE', '%' . $word . '%');
                        });
                }
            })
            ->when(isset($includedWords), function ($query) use ($includedWords) {
                foreach ($includedWords as $word) {
                    $query->where('description', 'LIKE', '%' . $word . '%')
                        ->orWhereHas('auction', function ($q) use ($word) {
                            $q->where('trade_id', 'LIKE', '%' . $word . '%');
                        });
                }
            })*/
        /*    ->when(isset($request->mainParams) && isset($request->mainParams['tradePlaces']) && count($request->mainParams['tradePlaces']) > 0, function ($query) use ($request) {
                return $query->whereHas('auction', function ($q) use ($request) {
                    $q->whereIn('trade_place_id', $request->mainParams['tradePlaces']);
                });
            })
            ->when(isset($request->mainParams) && isset($request->mainParams['tradeType']) && strlen((string)$request->mainParams['tradeType']) > 0, function ($query) use ($request) {
                return $query->whereHas('auction.auctionType', function ($q) use ($request) {
                    $q->where('title', $request->mainParams['tradeType']);
                });
            })*/
           /* ->when(isset($request->other) && isset($request->other['hasPhotos']) && $request->other['hasPhotos'] === true, function ($query) use ($request) {
                $query->has('lotImages');
            })
            ->when(isset($request->other) && isset($request->other['isStopped']) && $request->other['isStopped'] === true, function ($query) use ($request) {
                return $query->whereHas('status', function ($q) use ($request) {
                    $q->where('id', 10);
                });
            })
            ->when(isset($request->other) && isset($request->other['isCompleted']) && $request->other['isCompleted'] === true, function ($query) use ($request) {
                return $query->whereHas('status', function ($q) use ($request) {
                    $q->where('id', 6);
                });
            })
            ->when(isset($request->other) && isset($request->other['isHidden']) && $request->other['isHidden'] === true, function ($query) use ($request) {
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
            });*/


    }

    public function getPeriodDates($period)
    {
        $result = [];
        switch ($period) {
            case '1 day':
            {
                $result[0] = Carbon::now()->setTimezone('Europe/Moscow')->startOfDay();
                break;
            }
            case '7 days':
            {
                $result[0] = Carbon::now()->setTimezone('Europe/Moscow')->startOfDay()->subWeek();
                break;
            }
            case '30 days':
            {
                $result[0] = Carbon::now()->setTimezone('Europe/Moscow')->startOfDay()->subDays(30);
                break;
            }
        }
        $result[1] = Carbon::now()->setTimezone('Europe/Moscow')->endOfDay();
        return $result;
    }

}
