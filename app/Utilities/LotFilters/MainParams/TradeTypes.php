<?php

namespace App\Utilities\LotFilters\MainParams;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class TradeTypes extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        if(!is_null($value)  && count($value) > 0) {
            $this->query->whereHas('auction.auctionType', function ($q) use ($value) {
                $q->whereIn('title', $value);
            });
        }
    }
}
