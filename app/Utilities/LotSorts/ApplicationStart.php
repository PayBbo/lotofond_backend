<?php

namespace App\Utilities\LotSorts;

use App\Models\Auction;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class ApplicationStart extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $this->query->orderBy(Auction::select('application_start_date')
            ->whereColumn('auctions.id', 'lots.auction_id')->take(1),
            $direction
        );
    }
}
