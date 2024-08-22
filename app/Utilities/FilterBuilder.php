<?php

namespace App\Utilities;

use Illuminate\Support\Facades\DB;

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
        logger('start FilterBuilder');
        $names = [];
        foreach ($this->filters as $name => $value) {
            if (is_null($value) || (gettype($value) == 'array' && count($value)==0) || (gettype($value) == 'string' && strlen((string)$value) == 0)) {
                continue;
            }
            $normailizedName = ucfirst($name);
            $class = $this->namespace . "\\{$normailizedName}";
            logger('FilterBuilder class'.$class);
            if (!class_exists($class)) {
                continue;
            }
            $names[]=$normailizedName;
            if($name === 'dates'){
                foreach ($value as $item => $val){
                    (new $class($this->query))->handle($val, $item);
                }
            }else{
                (new $class($this->query))->handle($value, $name);
            }

        }
       if(auth()->check()) {
            if ($this->namespace == 'App\Utilities\LotFilters') {
                if (!in_array('ExtraOptions', $names)) {
                    $userId = auth()->id();
                    $this->query->whereDoesntHave("hiddenLots", function($subQuery) use($userId){
                        $subQuery->where("user_id", "=", $userId);
                    });
                }
            }
        }
        logger('end FilterBuilder');
        return $this->query;
    }
}
