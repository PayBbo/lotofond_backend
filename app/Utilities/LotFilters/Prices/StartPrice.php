<?php

namespace App\Utilities\LotFilters\Prices;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class StartPrice extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        if (!is_null($value) && strlen((string)$value['min']) > 0 && strlen((string)$value['max']) > 0) {
            $this->query->whereBetween('start_price', [$value['min'], $value['max']]);
        }
    }
}
