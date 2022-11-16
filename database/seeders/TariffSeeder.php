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
            ['title' => '1 месяц', 'description' => ' ', 'price' => 1000, 'admission_price' => 524, 'period' => 30, 'store_id' => '1_month'],
            ['title' => '3 месяца', 'description' => ' ', 'price' => 2750, 'admission_price' => 1323, 'period' => 90, 'store_id' => '3_months'],
            ['title' => '6 месяцев', 'description' => ' ', 'price' => 5400, 'admission_price' => 2443, 'period' => 180, 'store_id' => '6_months'],
            ['title' => '12 месяцев', 'description' => ' ', 'price' => 10800, 'admission_price' => 2443, 'period' => 180, 'store_id' => '12_months']
        ];
        foreach ($tariffs as $tariff)
            Tariff::create([
                'title' => $tariff['title'],
                'description' => $tariff['description'],
                'price' => $tariff['price'],
                'admission_price' => $tariff['admission_price'],
                'period' => $tariff['period'],
                'store_id' => $tariff['store_id']
            ]);
    }
}
