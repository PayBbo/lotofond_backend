<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;
use Carbon\Carbon;

class Other extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        $minDate = null;
        $maxDate = null;
        if (isset($value['period']) && strlen((string)$value['period']) > 0 && $value['period'] !== 'all') {
            $result = $this->getPeriodDates($value['period']);
            $minDate = $result[0];
            $maxDate = $result[1];
        }
        if(isset($value['hasPhotos']) && $value['hasPhotos'] === true) {
            $this->query->has('lotImages');
        }
        if(isset($value['isCompleted']) && $value['isCompleted'] === true) {
            $this->query->whereHas('status', function ($q)  {
                $q->where('id', 6);
            });
        }
        if(isset($value['isStopped']) && $value['isStopped'] === true) {
            $this->query->whereHas('status', function ($q)  {
                $q->where('id', 10);
            });
        }
        if(isset($value['isHidden']) && $value['isHidden'] === true) {
            $this->query->whereHas('status', function ($q)  {
                $q->where('id', 8);
            });
        }
        if(isset($minDate) && isset($maxDate)){
            $this->query->whereHas('auction', function ($q) use ($minDate, $maxDate) {
                $q->whereBetween('publish_date',
                    [$minDate, $maxDate]);
            });
        }

    }

    public function getPeriodDates($period)
    {
        $result = [];
        switch ($period) {
            case '1 day':
            {
                $result[0] = Carbon::now()->setTimezone('Europe/Moscow')->startOfDay();
                break;
            }
            case '7 days':
            {
                $result[0] = Carbon::now()->setTimezone('Europe/Moscow')->startOfDay()->subWeek();
                break;
            }
            case '30 days':
            {
                $result[0] = Carbon::now()->setTimezone('Europe/Moscow')->startOfDay()->subDays(30);
                break;
            }
        }
        $result[1] = Carbon::now()->setTimezone('Europe/Moscow')->endOfDay();
        return $result;
    }
}
