<?php

namespace App\Utilities\BidderSorts;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Name extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $this->query->orderBy('last_name', $direction)
            ->orderBy('name', $direction);
    }
}
