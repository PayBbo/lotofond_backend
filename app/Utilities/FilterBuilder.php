<?php

namespace App\Utilities;

class FilterBuilder
{
    protected $query;
    protected $filters;
    protected $namespace;

    public function __construct($query, $filters, $namespace)
    {
        $this->query = $query;
        $this->filters = $filters;
        $this->namespace = $namespace;
    }

    public function apply()
    {
        foreach ($this->filters as $name => $value) {
            if (is_null($value)) {
                continue;
            }
            $normailizedName = ucfirst($name);
            $class = $this->namespace . "\\{$normailizedName}";
            if (!class_exists($class)) {
                continue;
            }
            (new $class($this->query))->handle($value, $name);

        }
        return $this->query;
    }
}
