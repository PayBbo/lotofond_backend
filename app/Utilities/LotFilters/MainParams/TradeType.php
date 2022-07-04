<?php

namespace App\Utilities\LotFilters\MainParams;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class TradeType extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        if(!is_null($value)  && strlen($value) > 0) {
            $this->query->whereHas('auction.auctionType', function ($q) use ($value) {
                $q->where('title', $value);
            });
        }
    }
}
