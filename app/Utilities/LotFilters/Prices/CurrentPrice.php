<?php

namespace App\Utilities\LotFilters\Prices;

use App\Models\PriceReduction;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class CurrentPrice extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        $value = json_decode(json_encode($value), true);

        if (!is_null($value)) {
            $this->query->when(!is_null($value['min']) && strlen((string)$value['min']) > 0, function ($query) use ($value) {
                $query->whereHas('currentPriceReduction', function ($q) use ($value) {
                    $q->where('price', '>=', $value['min']);
                });
            })->when(!is_null($value['max']) && strlen((string)$value['max']) > 0, function ($query) use ($value) {
                $query->whereHas('currentPriceReduction', function ($q) use ($value) {
                    $q->where('price', '<=', $value['max']);
                });
            });
        }
    }
}
