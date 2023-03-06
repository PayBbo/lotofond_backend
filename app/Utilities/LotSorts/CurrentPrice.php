<?php

namespace App\Utilities\LotSorts;

use App\Models\PriceReduction;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;
use Carbon\Carbon;

class CurrentPrice extends SortQuery implements SortContract
{
    public function handle($direction): void
    {
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');
        /*  \DB::statement("SET SQL_MODE=''");
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
               ->groupBy(['lots.id']);*/
      /*  $this->query->orderBy(PriceReduction::select('price')
            ->whereColumn('lots.id', 'price_reductions.lot_id')
            ->where(function ($query) use ($currentDate) {
                $query->where('price_reductions.start_time', '<=',  $currentDate )
                    ->orWhereNull('price_reductions.start_time');
            })
            ->where(function ($query) use ($currentDate) {
                $query->where('price_reductions.end_time', '>',  $currentDate )
                    ->orWhereNull('price_reductions.end_time');
            })
            ->orderBy('end_time', 'desc')
            ->orderBy('start_time', 'desc')
            ->take(1),
            $direction
        );*/

        $sql = "(SELECT `price`
FROM `price_reductions`
WHERE `lots`.`id` = `price_reductions`.`lot_id`
AND (`price_reductions`.`start_time` <= NOW())
AND (`price_reductions`.`end_time` > NOW() OR `price_reductions`.`end_time` IS NULL)
ORDER BY `price_reductions`.`end_time` DESC, `price_reductions`.`start_time` DESC, `price_reductions`.`id` DESC
LIMIT 1)";

        $this->query->orderBy(\DB::raw($sql), $direction);


    }
}
