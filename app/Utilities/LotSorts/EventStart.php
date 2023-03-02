<?php

namespace App\Utilities\LotSorts;

use App\Models\Auction;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class EventStart extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
      /*  $this->query->orderBy(Auction::select('event_start_date')
            ->whereColumn('auctions.id', 'lots.auction_id')->take(1),
            $direction
        );*/
        $this->query->orderBy(\DB::raw('(SELECT `event_start_date` FROM `auctions` WHERE `id` = lots.`auction_id` LIMIT 1)'), $direction);
       /* $this->query->select('lots.*')
            ->join('auctions', 'auctions.id', '=', 'lots.auction_id')
            ->orderBy('auctions.event_start_date',  $direction);*/
    }
}
