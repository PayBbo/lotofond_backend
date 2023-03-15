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
                $conditions_desc[] = ['description', 'not like', "%$word%"];
                $conditions_type[] = ['trade_id', 'not like', "%$word%"];
            }
            $this->query->where(function ($query) use ($conditions_desc, $conditions_type) {
                $query->whereHas('auction', function ($q) use ($conditions_type) {
                    $q->where($conditions_type);
                })
                    ->where($conditions_desc);
            });
        }
    }
}
