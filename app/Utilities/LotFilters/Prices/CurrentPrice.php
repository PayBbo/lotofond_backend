<?php

namespace App\Utilities\LotFilters\Prices;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;
use Carbon\Carbon;

class CurrentPrice  extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');
        if(!is_null($value) && count($value)>0) {
            $this->query
                ->whereHas('priceReductions', function ($q) use ($value, $currentDate) {
                    $q->whereDate('start_time', '<=', $currentDate)->
                    whereDate('end_time', '>', $currentDate)->whereBetween('price',
                        [$value['min'], $value['max']]);
                });
        }
    }
}
