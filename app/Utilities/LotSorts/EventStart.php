<?php

namespace App\Utilities\LotSorts;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class EventStart extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $this->query->join('auctions', 'auctions.id', '=', 'lots.auction_id')
            ->orderBy('auctions.event_start_date', $direction);
    }
}
