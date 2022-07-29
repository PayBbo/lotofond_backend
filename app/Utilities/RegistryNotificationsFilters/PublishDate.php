<?php

namespace App\Utilities\RegistryNotificationsFilters;

use App\Models\RegistryNotification;
use App\Utilities\SortContract;
use App\Utilities\SortQuery;
use Carbon\Carbon;

class PublishDate extends SortQuery implements SortContract
{

    public function handle($value): void
    {
        if (!is_null($value) && isset($value['start']) && strlen((string)$value['start']) > 0) {
            $start = Carbon::parse($value['start']);
        } else {
            $start = RegistryNotification::min('publish_date');
        }
        if (!is_null($value) && isset($value['end']) && strlen((string)$value['end']) > 0) {
            $end = Carbon::parse($value['end']);
        } else {
            $end = RegistryNotification::max('publish_date');
        }
        $this->query->whereBetween('publish_date', [$start, $end]);


    }
}
