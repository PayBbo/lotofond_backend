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
            $this->query->orderBy(PriceReduction::select('price')
                ->whereColumn('price_reductions.lot_id', 'lots.id')
                ->where('price_reductions.start_time', '<=', $currentDate)
                ->where('price_reductions.end_time', '>', $currentDate)
                ->take(1),
                $direction
            );
    }
}
