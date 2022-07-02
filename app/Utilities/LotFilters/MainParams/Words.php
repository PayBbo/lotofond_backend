<?php

namespace App\Utilities\LotFilters\MainParams;

use App\Utilities\SortQuery;

class Words extends SortQuery
{
    public function handle($value, $type): void
    {
        $words = null;
        if (!is_null($value) && strlen((string)$value) > 0) {
            $words = explode(',', $value);
        }
        if(!is_null($words)) {
            if ($type == 'excludedWords') {
                $like = 'NOT LIKE';
            } else {
                $like = 'LIKE';
            }

            foreach ($words as $word) {
                $this->query->where('description', $like, '%' . $word . '%')
                    ->orWhereHas('auction', function ($q) use ($word, $like) {
                        $q->where('trade_id', $like, '%' . $word . '%');
                    });
            }
        }

    }
}
