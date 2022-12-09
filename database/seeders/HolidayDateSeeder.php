<?php

namespace Database\Seeders;

use App\Models\HolidayDate;
use Illuminate\Database\Seeder;

class HolidayDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dates = [
            '31.12.2022',
            '01.01.2023',
            '02.01.2023',
            '03.01.2023',
            '04.01.2023',
            '05.01.2023',
            '06.01.2023',
            '07.01.2023',
            '08.01.2023',
            '23.02.2023',
            '24.02.2023',
            '25.02.2023',
            '26.02.2023',
            '29.04.2023',
            '30.04.2023',
            '01.05.2023',
            '06.05.2023',
            '07.05.2023',
            '08.05.2023',
            '09.05.2023',
            '10.06.2023',
            '11.06.2023',
            '12.06.2023',
            '04.11.2023',
            '05.11.2023',
            '06.11.2023'
        ];
        foreach ($dates as $date){
            HolidayDate::create([
                'date'=>$date
            ]);
        }
    }
}
