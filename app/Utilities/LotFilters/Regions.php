<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Regions extends SortQuery implements SortContract
{

    public function handle($value): void
    {
        if(!is_null($value) && count($value)>0) {
            $this->query->whereHas('regions', function ($q) use ($value) {
                $q->whereIn('code', $value);
            });
        }
    }
}
