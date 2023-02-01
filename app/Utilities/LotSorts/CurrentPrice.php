<?php

namespace App\Utilities\LotSorts;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;
use Carbon\Carbon;

class CurrentPrice extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');
        \DB::statement("SET SQL_MODE=''");
         $this->query->with('priceReductions')
            ->join('price_reductions as i', 'lots.id', '=', 'i.lot_id')
            ->select('lots.*')
            ->where(function ($query) use ($currentDate) {
              //  $query->whereDate('i.start_time', '<=', DB::raw("str_to_date('" . $currentDate . "', '%d.%m.%Y')"))
                $query->where('i.start_time', '<=',  $currentDate )
                    ->orWhere('i.start_time', '=', null);
            })
            ->where(function ($query) use ($currentDate) {
               // $query ->whereDate('i.end_time', '>', DB::raw("str_to_date('" . $currentDate . "', '%d.%m.%Y')"))
                $query->where('i.end_time', '>',  $currentDate )
                    ->orWhere('i.end_time', '=', null);
            })
            ->orderBy('i.price', $direction)
            ->groupBy(['lots.id']);

    }
}
