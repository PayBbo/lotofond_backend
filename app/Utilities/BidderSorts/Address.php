<?php

namespace App\Utilities\BidderSorts;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Address extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $this->query->orderBy('address', $direction);
    }
}
