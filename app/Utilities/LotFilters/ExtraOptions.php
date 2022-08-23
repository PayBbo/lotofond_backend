<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

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
            $this->query->doesntHave('userHiddenLot');
        }
    }

}
