<?php

namespace Database\Seeders;

use App\Models\Param;
use Illuminate\Database\Seeder;

class ParamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $params = [
            ['type' => 'cadastralDataPrice',
                'title'=>'Кадастровая стоимость'],
            ['type' => 'cadastralDataArea',
                'title'=>'Кадастровые данные о площади'],
            ['type' => 'cadastralDataFractionalOwnership',
                'title'=>'Кадастровые данные о частичном владении'],
            ['type' => 'other',
                'title'=>'Кадастровый номер'],
            ['type' => 'other',
                'title'=>'Государственный номер транспорта'],
            ['type' => 'other',
            'title'=>'VIN транспорта'],
            ['type' => 'other',
                'title'=>'Адрес'],
            ['type' => 'other',
                'title'=>'Количество этажей'],
            ['type' => 'other',
                'title'=>'Год постройки'],
            ['type' => 'other',
                'title'=>'Тип постройки']
        ];
        foreach($params as $param){
            Param::create([
                'type'=>$param['type'],
                'title'=>$param['title']
            ]);
        }
    }
}
