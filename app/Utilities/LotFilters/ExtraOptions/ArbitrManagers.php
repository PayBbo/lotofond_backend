<?php

namespace App\Utilities\LotFilters\ExtraOptions;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class ArbitrManagers extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        if (!is_null($value) && count($value) > 0) {
            $this->query->whereHas('auction.arbitrManager', function ($q) use ($value) {
                $q->whereIn('id', $value);
            });
        }
    }
}
