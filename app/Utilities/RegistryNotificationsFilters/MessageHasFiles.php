<?php

namespace App\Utilities\RegistryNotificationsFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class MessageHasFiles extends SortQuery implements SortContract
{

    public function handle($value): void
    {
        if(!is_null($value) && $value === true) {
            $this->query->where('files', '!=', null);
        }
    }
}
