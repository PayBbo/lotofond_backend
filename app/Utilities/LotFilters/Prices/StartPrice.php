<?php

namespace App\Utilities\LotFilters\Prices;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class StartPrice extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        $value = json_decode(json_encode($value), true);

        if (!is_null($value)) {
            $this->query->when(!is_null($value['min']) && strlen((string)$value['min']) > 0, function ($query) use ($value) {
                $query->where('start_price', '>=', $value['min']);
            })->when(!is_null($value['max']) && strlen((string)$value['max']) > 0, function ($query) use ($value) {
                $query->where('start_price', '<=', $value['max']);
            });
        }
    }
}
