<?php

namespace App\Utilities\LotFilters\MainParams;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class TradePlaces extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        if(!is_null($value) && count($value)>0) {
            $this->query->whereHas('auction', function ($q) use ($value) {
                $q->whereIn('trade_place_id', $value);
            });
        }
    }
}
