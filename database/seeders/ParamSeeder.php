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
            ['type' => 'cadastralDataObjectAddress',
                'title'=>'Кадастровые данные об адресе'],
            ['type' => 'other',
                'title'=>'Кадастровый номер'],
            ['type' => 'other',
                'title'=>'Государственный номер автомобиля'],
            ['type' => 'other',
            'title'=>'VIN автомобиля']
        ];
        foreach($params as $param){
            Param::create([
                'type'=>$param['type'],
                'title'=>$param['title']
            ]);
        }
    }
}
