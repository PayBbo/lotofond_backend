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
                'title'=>
                    ['ru'=>'Кадастровая стоимость',
                    'en'=>'Cadastral value',
                    'zh_CN'=>'地籍价值']],
            ['type' => 'cadastralDataArea',
                'title'=>
                    ['ru'=>'Кадастровые данные о площади',
                    'en'=>'Cadastral data on the area',
                    'zh_CN'=>'该地区的地籍数据']],
            ['type' => 'cadastralDataFractionalOwnership',
                'title'=>
                    ['ru'=>'Кадастровые данные о частичном владении',
                    'en'=>'Cadastral data on partial ownership',
                    'zh_CN'=>'关于部分所有权的地籍数据']],
            ['type' => 'other',
                'title'=>
                    ['ru'=>'Кадастровый номер',
                    'en'=>'Cadastral number',
                    'zh_CN'=>'地籍编号']],
            ['type' => 'other',
                'title'=>
                    ['ru'=>'Государственный номер автомобиля',
                        'en'=>'The state number of the car',
                        'zh_CN'=>'汽车的状态号']],
            ['type' => 'other',
            'title'=>
                ['ru'=>'VIN автомобиля',
                    'en'=>'Vehicle VIN',
                    'zh_CN'=>'车辆VIN']]
        ];
        foreach($params as $param){
            Param::create([
                'type'=>$param['type'],
                'title'=>$param['title']
            ]);
        }
    }
}
