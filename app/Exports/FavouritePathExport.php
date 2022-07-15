<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FavouritePathExport implements FromCollection, WithHeadings
{
    protected $headings;
    protected $collection;

    public function __construct($headings, $collection){
        $this->headings = $headings;
        $this->collection = $collection;
    }

    public function headings(): array
    {
        return $this->headings;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->collection;
    }
}
