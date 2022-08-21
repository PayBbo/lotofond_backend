<?php

namespace App\Utilities\LotFilters;

use App\Models\Auction;
use App\Utilities\SortQuery;
use Carbon\Carbon;

class Dates extends SortQuery
{
    protected $start;
    protected $end;

    public function handle($value, $type): void
    {
        $field = null;
        switch ($type) {
            case 'applicationTimeEnd':
            {
                $field = 'application_end_date';
                break;
            }
            case 'applicationTimeStart':
            {
                $field = 'application_start_date';
                break;
            }
            case 'eventTimeEnd':
            {
                $field = 'event_end_date';
                break;
            }
            case 'eventTimeStart':
            {
                $field = 'event_start_date';
                break;
            }
        }
        if (!is_null($field)) {
            $this->getDates($value, $field);
            $start = $this->start;
            $end = $this->end;
            $this->query->when(isset($start), function ($query) use($start, $field){
                $query->whereHas('auction', function ($q) use ($start, $field) {
                    $q->where($field, '>=', $start);
                });
            })->when(isset($end), function ($query) use($end, $field){
                $query->whereHas('auction', function ($q) use ($end, $field) {
                    $q->where($field, '<=', $end);
                });
            });


        }
    }

    public function getDates($value, $field)
    {
        $value = json_decode(json_encode($value), true);
        $this->start = null;
        $this->end = null;
        if (!is_null($value) && isset($value['start']) && strlen((string)$value['start']) > 0) {
            $this->start = Carbon::parse($value['start']);
        }
        if (!is_null($value) && isset($value['end']) && strlen((string)$value['end']) > 0) {
            $this->end = Carbon::parse($value['end']);
        }
    }
}
