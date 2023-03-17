<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class SearchString extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        if (!is_null($value) && strlen((string)$value) > 0) {
            $keywords = explode(' ', $value);
            $searchTerm = '';

            foreach ($keywords as $keyword) {
                if(str_starts_with($keyword, ' ')){
                    $keyword = substr($keyword, 1, strlen($keyword));
                }
                $searchTerm .= "%" . $keyword;
            }
            $this->query->where(function ($query) use ($value,$searchTerm) {
                $query->whereHas('auction', function ($q) use ($value) {
                    $q->where('trade_id', 'like', '%' . $value . '%');
                })
                ->orWhere('description', 'like', $searchTerm . '%');
            });
        }
    }
}
