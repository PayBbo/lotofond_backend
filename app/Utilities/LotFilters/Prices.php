<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class Prices extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        foreach ($value as $val => $item) {
            $normailizedVal = ucfirst($val);

            $class = "App\Utilities\LotFilters\Prices" . "\\{$normailizedVal}";
            if (!class_exists($class)) {
                continue;
            }
            (new $class($this->query))->handle($item);
        }
    }

}
