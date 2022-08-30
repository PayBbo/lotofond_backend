<?php

namespace App\Utilities\LotFilters\Prices;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;
use Illuminate\Support\Facades\DB;

class MinPrice extends SortQuery implements SortContract
{

    public function handle($value): void
    {
        $value = json_decode(json_encode($value), true);
        if (!is_null($value)) {
            $this->query->with('priceReductions')->join('price_reductions as r', 'lots.id', '=', 'r.lot_id')
                ->select('lots.*')
                ->when(!is_null($value['min']) && strlen((string)$value['min']) > 0, function ($query) use ($value) {
                    $query->having(DB::raw('min(r.price)'), '>=', $value['min']);
                })
                ->when(!is_null($value['max']) && strlen((string)$value['max']) > 0, function ($query) use ($value) {
                    $query->having(DB::raw('min(r.price)'), '<=', $value['max']);
                });
        }
    }


}
