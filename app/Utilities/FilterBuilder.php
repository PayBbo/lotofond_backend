<?php

namespace App\Utilities;

use App\Utilities\LotFilters\Dates;
use App\Utilities\LotFilters\MainParams\Words;

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
            $normailizedName = ucfirst($name);
            $class = $this->namespace . "\\{$normailizedName}";
            if ($name == 'dates' || $name == 'prices' || $name == 'extraOptions' || $name === 'mainParams') {
                foreach ($value as $val => $item) {
                    if ($val == 'excludedWords' || $val == 'includedWords') {
                        $words = new Words($this->query);
                        $words->handle($item, $val);
                    } elseif ($val == 'applicationTimeEnd' || $val == 'applicationTimeStart'
                        || $val == 'eventTimeEnd' || $val == 'eventTimeStart') {
                        $dates = new Dates($this->query);
                        $dates->handle($item, $val);
                    } else {
                        $normailizedVal = ucfirst($val);
                        $class .= "\\{$normailizedVal}";
                        if (!class_exists($class)) {
                            continue;
                        }
                        (new $class($this->query))->handle($item);
                    }
                }
            }else {

                if (!class_exists($class)) {
                    continue;
                }
                (new $class($this->query))->handle($value);
            }

        }

        return $this->query;
    }
}
