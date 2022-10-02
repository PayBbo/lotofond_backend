<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Regions extends SortQuery implements SortContract
{

    public function handle($value): void
    {
        if(!is_null($value) && count($value)>0) {
            $this->query->where(function ($query) use ($value){
                $query->whereHas('objectRegions', function ($q) use ($value) {
                    $q->whereIn('code', $value);
                })->orWhereDoesntHave('objectRegions', function () use ($value) {
                    $this->query->whereHas('regions', function ($que) use ($value) {
                        $que->whereIn('code', $value);
                    });
                });
            });

        }
    }
}
