<?php

namespace App\Utilities\LotFilters\Prices;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class MinPrice  extends SortQuery implements SortContract
{

    public function handle($value): void
    {
        if(!is_null($value) && strlen((string)$value['min']) > 0 && strlen((string)$value['max']) > 0) {
            $this->query->whereHas('priceReductionsMin', function ($q) use ($value) {
                $q->whereBetween('price',
                    [(float)$value['min'], (float)$value['max']]);
            });
        }
    }
}
