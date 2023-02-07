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
        if(!auth()->guard('api')->check() && $this->namespace == 'App\Utilities\LotSorts'){
            $this->query->select('lots.*')
                ->join('lot_files', 'lot_files.lot_id', '=', 'lots.id')
                ->where(['lot_files.user_id'=> null, 'lot_files.type'=>'image'])
                ->groupBy('lots.id')
                ->orderByRaw('max(lot_files.created_at) desc');
        }
        return $this->query;
    }
}
