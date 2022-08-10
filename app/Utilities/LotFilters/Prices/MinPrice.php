<?php

namespace App\Utilities\LotFilters\Prices;

use App\Models\PriceReduction;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class MinPrice  extends SortQuery implements SortContract
{

    public function handle($value): void
    {
        $value = json_decode(json_encode($value), true);
        if(strlen((string)$value['min']) == 0 || is_null($value['min'])){
            $value['min'] = 0;
        }
        if(strlen((string)$value['max']) == 0 || is_null($value['max'])){
            $value['max'] = PriceReduction::max('price');
        }
        if(!is_null($value) && strlen((string)$value['min']) > 0 && strlen((string)$value['max']) > 0) {
            $this->query->whereHas('priceReductionMin', function ($q) use ($value) {
                $q->whereBetween('price', [$value['min'], $value['max']]);
            });
        }
    }
}
