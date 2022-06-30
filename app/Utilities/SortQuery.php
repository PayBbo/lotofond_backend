<?php

namespace App\Utilities;

abstract class SortQuery
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

}
