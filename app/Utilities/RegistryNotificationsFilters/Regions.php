<?php

namespace App\Utilities\RegistryNotificationsFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Regions extends SortQuery implements SortContract
{

    public function handle($value): void
    {
        if(!is_null($value) && count($value)>0) {
            $this->query->whereHas('debtor.region', function ($q) use ($value) {
                $q->whereIn('code', $value);
            });
        }
    }
}
