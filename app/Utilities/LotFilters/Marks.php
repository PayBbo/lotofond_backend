<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Marks extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        if(!is_null($value) && count($value)>0) {
            $this->query->whereHas('userMarksForSearch', function ($q) use ($value) {
                $q->whereIn('id', $value);
            });
        }
    }
}
