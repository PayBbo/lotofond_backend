<?php

namespace App\Utilities\LotSorts;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class ApplicationEnd extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $this->query->join('auctions', 'auctions.id', '=', 'lots.auction_id')
            ->orderBy('auctions.application_end_date', $direction);
    }
}
