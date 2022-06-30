<?php

namespace App\Utilities\LotSorts;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class PublishDate extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $this->query->join('auctions', 'auctions.id', '=', 'lots.auction_id')
            ->orderBy('auctions.publish_date', $direction);
    }
}
