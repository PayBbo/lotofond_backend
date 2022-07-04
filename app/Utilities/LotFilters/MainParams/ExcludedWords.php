<?php

namespace App\Utilities\LotFilters\MainParams;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class ExcludedWords extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        $words = null;
        if (!is_null($value) && strlen((string)$value) > 0) {
            $words = explode(',', $value);
        }
        $conditions_desc = [];
        $conditions_type = [];
        if (!is_null($words)) {
            foreach ($words as $word) {

                $conditions_desc[] = ['description', 'not like', '%' . $word . '%'];
                $conditions_type[] = ['trade_id', 'not like', '%' . $word . '%'];
            }
            $this->query
                ->whereHas('auction', function ($q) use ($value, $conditions_type) {
                    $q->where($conditions_type);
                })
                ->orWhere($conditions_desc);
        }
    }
}
