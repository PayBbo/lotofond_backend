<?php

namespace App\Utilities\LotFilters\Prices;

use App\Models\PriceReduction;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;
use Carbon\Carbon;

class PercentageReduction  extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        if(strlen((string)$value['min']) == 0 || is_null($value['min'])){
            $value['min'] = 0;
        }
        if(strlen((string)$value['max']) == 0 || is_null($value['max'])){
            $value['max'] = PriceReduction::max('percent');
        }

        if(!is_null($value) && strlen((string)$value['min']) > 0 && strlen((string)$value['max']) > 0) {
            $this->query->whereHas('currentPriceReduction', function ($q) use ($value) {
                return $q->whereBetween('percent',
                    [$value['min'], $value['max']]);
            });
        }
    }
}
