<?php

namespace App\Utilities\LotSorts;

use App\Models\PriceReduction;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CurrentPrice extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow')->format('d.m.Y');
        \DB::statement("SET SQL_MODE=''");
        $this->query->with('priceReductions')
            ->join('price_reductions as i', 'lots.id', '=', 'i.lot_id')
            ->select('lots.*')
            ->whereDate('i.start_time', '<=', DB::raw("str_to_date('" . $currentDate . "', '%d.%m.%Y')"))
            ->where(function ($query) use ($currentDate) {
                $query  ->whereDate('i.end_time', '>', DB::raw("str_to_date('" . $currentDate . "', '%d.%m.%Y')"))
                    ->orWhere('i.end_time', '=', null);
            })
            ->orderBy('i.price', $direction)
            ->groupBy(['lots.id']);

    }
}
