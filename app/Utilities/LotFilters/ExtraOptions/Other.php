<?php

namespace App\Utilities\LotFilters\ExtraOptions;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Other extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        $value = json_decode(json_encode($value), true);
        $minDate = null;
        $maxDate = null;
        if (!is_null($value) && isset($value['period']) && strlen((string)$value['period']) > 0 && $value['period'] !== 'periodAll') {
            $result = $this->getPeriodDates($value['period']);
            $minDate = $result[0];
            $maxDate = $result[1];
        }
        if(!is_null($value) && isset($value['hasPhotos']) && $value['hasPhotos'] === true) {
            $this->query->hasByNonDependentSubquery('lotImages', function ($q) {
                $q->where('user_id', null)
                ->orWhere('user_id', auth()->guard('api')->id());
            });
        }
        if(!is_null($value) && isset($value['isCompleted']) && $value['isCompleted'] === true) {
            $this->query->hasByNonDependentSubquery('status', function ($q)  {
                $q->where('id', 6);
            });
        }
        if(!is_null($value) && isset($value['isStopped']) && $value['isStopped'] === true) {
            $this->query->hasByNonDependentSubquery('status', function ($q)  {
                $q->where('id', 10);
            });
        }
       if(!is_null($value) && isset($value['isHidden']) && $value['isHidden'] === true && auth()->check()) {
            $userId = auth()->id();
            $this->query->whereHas("hiddenLots", function($subQuery) use($userId){
                $subQuery->where("user_id", "=", $userId);
            });
        }

       if(!$value['isHidden'] && auth()->check()) {
          $userId = auth()->id();
           $this->query->whereDoesntHave("hiddenLots", function($subQuery) use($userId){
               $subQuery->where("user_id", "=", $userId);
           });

        }
        if(isset($minDate) && isset($maxDate)){
            $this->query->hasByNonDependentSubquery('auction', function ($q) use ($minDate, $maxDate) {
                $q->whereBetween('publish_date',
                    [$minDate, $maxDate]);
            });
        }

    }

    public function getPeriodDates($period)
    {
        $result = [];
        switch ($period) {
            case 'periodDay':
            {
                $result[0] = Carbon::now()->setTimezone('Europe/Moscow')->startOfDay();
                break;
            }
            case 'periodWeek':
            {
                $result[0] = Carbon::now()->setTimezone('Europe/Moscow')->startOfDay()->subWeek();
                break;
            }
            case 'periodMonth':
            {
                $result[0] = Carbon::now()->setTimezone('Europe/Moscow')->startOfDay()->subDays(30);
                break;
            }
        }
        $result[1] = Carbon::now()->setTimezone('Europe/Moscow')->endOfDay();
        return $result;
    }
}
