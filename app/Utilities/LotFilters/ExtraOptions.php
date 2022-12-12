<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;
use Illuminate\Support\Facades\DB;

class ExtraOptions  extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        $names = [];
        foreach ($value as $val => $item) {
            $normailizedVal = ucfirst($val);

            $class = "App\Utilities\LotFilters\ExtraOptions" . "\\{$normailizedVal}";
            if (!class_exists($class)) {
                continue;
            }
            $names[]=$normailizedVal;
            (new $class($this->query))->handle($item);
        }
        if(!in_array('Other', $names)){
            $userId = auth()->id();
            $this->query->whereDoesntHave("hiddenLots", function($subQuery) use($userId){
                $subQuery->where("user_id", "=", $userId);
            });
        }
    }

}
