<?php

namespace App\Utilities\LotSorts;

use App\Models\Auction;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class PublishDate extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
       /*$this->query->select('lots.*')
            ->join('auctions', 'auctions.id', '=', 'lots.auction_id')
            ->orderBy('auctions.publish_date',  $direction);*/
      //  $this->query->leftJoin('auctions as a', 'lots.auction_id', '=', 'a.id')->orderBy('a.publish_date', 'desc');
        $this->query->orderBy(\DB::raw('(SELECT `publish_date` FROM `auctions` WHERE `id` = lots.`auction_id` LIMIT 1)'), $direction);

    }
}
