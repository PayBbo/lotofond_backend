<?php

namespace App\Utilities\RegistryNotificationsFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class SearchString extends SortQuery implements SortContract
{

    public function handle($value): void
    {
        if(!is_null($value) && strlen($value)>0) {
            $this->query->whereHas('debtor', function($query) use ($value) {
                $query->where('name', 'LIKE', '%' . $value . '%')
                    ->orWhere('short_name', 'LIKE', '%' . $value . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $value  . '%')
                    ->orWhere('middle_name', 'LIKE', '%' . $value  . '%')
                    ->orWhere('inn', 'LIKE', '%' . $value  . '%');
            });
        }
    }
}
