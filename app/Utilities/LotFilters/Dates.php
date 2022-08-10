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
            $this->query->whereHas('auction', function ($q) use ($start, $end, $field) {
                $q->whereBetween($field, [$start, $end]);
            });

        }
    }

    public function getDates($value, $field)
    {
        $value = json_decode(json_encode($value), true);
        if (!is_null($value) && isset($value['start']) && strlen((string)$value['start']) > 0) {
            $start = Carbon::parse($value['start']);
        } else {
            $start = Auction::min($field);
        }
        if (!is_null($value) && isset($value['end']) && strlen((string)$value['end']) > 0) {
            $end = Carbon::parse($value['end']);
        } else {
            $end = Auction::max($field);
        }
        $this->start = $start;
        $this->end = $end;
    }
}
