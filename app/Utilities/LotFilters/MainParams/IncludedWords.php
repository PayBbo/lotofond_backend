<?php

namespace App\Utilities\LotFilters\MainParams;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class IncludedWords extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        $words = null;
        if (!is_null($value) && strlen((string)$value) > 0) {
            if(strpos($value, ',') !== false){
                $words = explode(',', $value);
            }else {
                $words = explode(' ', $value);
            }
        }
        $conditions_desc = [];
        $conditions_type = [];
        if (!is_null($words)) {
            foreach ($words as $word) {
                if(str_starts_with($word, ' ')){
                    $word = substr($word, 1, strlen($word));
                }
                $conditions_desc[] = ['description', 'like', '%' . $word . '%'];
                $conditions_type[] = ['trade_id', 'like', '%' . $word . '%'];
            }
            $this->query->where(function ($query) use ($conditions_desc, $conditions_type) {
                $query->whereHas('auction', function ($q) use ($conditions_type) {
                    $q->where($conditions_type);
                })
                    ->orWhere($conditions_desc);
            });
        }
    }
}
