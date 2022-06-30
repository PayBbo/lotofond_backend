<?php

namespace App\Utilities;

class SortBuilder
{
    protected $query;
    protected $sort;
    protected $namespace;

    public function __construct($query, $sort, $namespace)
    {
        $this->query = $query;
        $this->sort = $sort;
        $this->namespace = $namespace;
    }

    public function apply()
    {
        $normailizedName = ucfirst($this->sort['type']);
        $class = $this->namespace . "\\{$normailizedName}";
        (new $class($this->query))->handle($this->sort['direction']);
        return $this->query;
    }
}
