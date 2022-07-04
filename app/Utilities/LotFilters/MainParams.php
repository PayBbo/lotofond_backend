<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class MainParams extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        foreach ($value as $val => $item) {
            $normailizedVal = ucfirst($val);

            $class = "App\Utilities\LotFilters\MainParams" . "\\{$normailizedVal}";
            if (!class_exists($class)) {
                continue;
            }
            (new $class($this->query))->handle($item);
        }
    }

}
