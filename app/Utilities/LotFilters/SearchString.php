<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class SearchString extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        if(!is_null($value) && strlen((string)$value) > 0) {
            $this->query->where(function ($query) use ($value) {
                $query->whereHas('auction', function ($q) use ($value) {
                    $q->where('trade_id', 'like', '%' . $value . '%');
                })
                    ->orWhere('description', 'like', '%' . $value . '%');
            });
        }
    }
}
