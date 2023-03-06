<?php

namespace App\Utilities\LotFilters\Prices;

use App\Models\PriceReduction;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CurrentPrice extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        $value = json_decode(json_encode($value), true);

        if (!is_null($value)) {
            $minPrice = (!is_null($value['min']) && strlen((string)$value['min']) > 0) ? $value['min'] : null;
            $maxPrice = (!is_null($value['max']) && strlen((string)$value['max']) > 0) ? $value['max'] : null;
            if($minPrice || $maxPrice) {
                $this->query->whereHas('currentPriceReductionForFilter', function ($q) use ($minPrice, $maxPrice) {
                    if ($minPrice) {
                        $q->where('price', '>=', $minPrice);
                    }
                    if ($maxPrice) {
                        $q->where('price', '<=', $maxPrice);
                    }
                });
            }

        }
    }
}
