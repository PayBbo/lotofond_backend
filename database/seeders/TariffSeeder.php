<?php

namespace Database\Seeders;

use App\Models\Tariff;
use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tariffs = [
            ['title'=>'1 месяц', 'description'=>'Расширенные возможности приложения на 1 месяц', 'price'=>749, 'admission_price'=>524, 'period'=>30, 'store_id'=>'1_month'],
            ['title'=>'3 месяца', 'description'=>'Расширенные возможности приложения на 3 месяца', 'price'=> 1890, 'admission_price'=>1323, 'period'=>90, 'store_id'=>'3_months'],
            ['title'=>'6 месяцев', 'description'=>'Расширенные возможности приложения на 6 месяцев', 'price'=>3490, 'admission_price'=>2443, 'period'=>180, 'store_id'=>'6_months']
        ];
        foreach ($tariffs as $tariff)
            Tariff::create([
                'title' => $tariff['title'],
                'description' => $tariff['description'],
                'price' => $tariff['price'],
                'admission_price' => $tariff['admission_price'],
                'period' => $tariff['period'],
                'store_id'=>$tariff['store_id']
            ]);
    }
}
