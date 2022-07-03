<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Regions extends SortQuery implements SortContract
{
    /*TODO: Когда будут регионы у  лотов, изменить фильтр*/

    public function handle($value): void
    {
        if(!is_null($value) && count($value)>0) {
            $this->query->whereHas('auction.debtor.region', function ($q) use ($value) {
                $q->whereIn('title', $value);
            });
        }
    }
}
