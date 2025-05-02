<?php

namespace App\Utilities\LotFilters;

use App\Models\Region;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Regions extends SortQuery implements SortContract
{

    public function handle($value): void
    {
        if(!is_null($value) && count($value)>0) {
            $regions = Region::whereIn('code', $value)->get();
            $centers = $regions->where('is_center', true)->pluck('title')->toArray();
            $codes = $regions->where('is_center', false)->pluck('code')->toArray();
          /*  $this->query->where(function ($query) use ($value){
                $query->whereHas('objectRegions', function ($q) use ($value) {
                    $q->whereIn('code', $value);
                })->orWhereDoesntHave('objectRegions', function () use ($value) {
                    $this->query->whereHas('regions', function ($que) use ($value) {
                        $que->whereIn('code', $value);
                    });
                });
            });*/

            $this->query
                ->when(count($codes), function ($query) use($codes, $centers) {
                    $query->where(function ($qr) use ($codes, $centers){
                        $qr->hasByNonDependentSubquery('objectRegions', function ($q) use ($codes, $centers) {
                            $q->whereIn('code', $codes);
                            foreach ($centers as $center) {
                                $q->orWhere('lots.description', 'like', '%' . str_replace('г. ', '', $center) . '%');
                            }
                        })->orDoesntHaveByNonDependentSubquery('objectRegions', function () use ($codes, $centers) {
                            $this->query->hasByNonDependentSubquery('regions', function ($que) use ($codes, $centers) {
                                $que->whereIn('code', $codes);
                                foreach ($centers as $center) {
                                    $que->orWhere('lots.description', 'like', '%' . str_replace('г. ', '', $center) . '%');
                                }
                            });
                        });
                    });
                 })
                ->when(count($centers) && !count($codes), function ($query) use ($centers) {
                    $query->where(function ($q) use ($centers) {
                        foreach ($centers as $center) {
                            $q->orWhere('lots.description', 'like', '%' . str_replace('г. ', '', $center) . '%');
                        }
                    });
                });


        }
    }
}
