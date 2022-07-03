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
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');
        if(strlen((string)$value['min']) == 0 || is_null($value['min'])){
            $value['min'] = 0;
        }
        if(strlen((string)$value['max']) == 0 || is_null($value['max'])){
            $value['max'] = PriceReduction::max('percent');
        }
        if(!is_null($value) && strlen((string)$value['min']) > 0 && strlen((string)$value['max']) > 0) {
            $this->query->whereHas('priceReductions', function ($q) use ($value, $currentDate) {
                $q->whereDate('start_time', '<=', $currentDate)->
                whereDate('end_time', '>', $currentDate)->whereBetween('percent',
                    [$value['min'], $value['max']]);
            });
        }
    }
}
