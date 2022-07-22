<?php

namespace App\Utilities\BidderSorts;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Region extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $this->query->orderBy(\App\Models\Region::select('title')
            ->whereColumn('regions.id', 'bidders.region_id')->take(1),
            $direction
        );
    }
}
