<?php

namespace App\Utilities\RegistryNotificationsSort;

use App\Models\Bidder;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Debtor extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $this->query->orderBy(Bidder::select('last_name')
            ->whereColumn('bidders.id', 'registry_notifications.debtor_id')->take(1),
            $direction
        )->orderBy(Bidder::select('name')
            ->whereColumn('bidders.id', 'registry_notifications.debtor_id')->take(1),
            $direction
        );
    }
}
