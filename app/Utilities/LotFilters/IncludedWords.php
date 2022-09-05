<?php

namespace App\Utilities\LotFilters;

use App\Utilities\SortContract;
use App\Utilities\SortQuery;

class IncludedWords extends SortQuery implements SortContract
{
    public function handle($value): void
    {
        $class = "App\Utilities\LotFilters\MainParams\IncludedWords";
        (new $class($this->query))->handle($value);
    }
}
