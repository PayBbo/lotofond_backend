<?php

namespace App\Utilities\LotSorts;

use App\Models\Auction;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class PublishDate extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
       /* $this->query->orderBy(Auction::select('publish_date')
            ->whereColumn('auctions.id', 'lots.auction_id')->take(1),
            $direction
        );*/
        $this->query->select('lots.*')
            ->join('auctions', 'auctions.id', '=', 'lots.auction_id')
            ->orderBy('auctions.publish_date',  $direction);
    }
}
