<?php

namespace App\Utilities\BidderSorts;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Id extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $this->query->orderByRaw('CAST(id as UNSIGNED) '. $direction);
    }
}
