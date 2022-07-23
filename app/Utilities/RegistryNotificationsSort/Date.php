<?php

namespace App\Utilities\RegistryNotificationsSort;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Date  extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $this->query->orderBy('publish_date', $direction);
    }
}
