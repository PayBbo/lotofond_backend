<?php

namespace Database\Seeders;

use App\Models\TradePlace;
use Illuminate\Database\Seeder;

class TradePlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tradePlaces = [
            ['name'=>'', 'owner_name'=>'', 'inn'=>'', 'site'=>'',
                'trade_place_category_id'=>1],
            ['name'=>'', 'owner_name'=>'', 'inn'=>'', 'site'=>'',
                'trade_place_category_id'=>1],
            ['name'=>'', 'owner_name'=>'', 'inn'=>'', 'site'=>'',
                'trade_place_category_id'=>1],
            ['name'=>'', 'owner_name'=>'', 'inn'=>'', 'site'=>'',
                'trade_place_category_id'=>1],
            ['name'=>'', 'owner_name'=>'', 'inn'=>'', 'site'=>'',
                'trade_place_category_id'=>1],
            ['name'=>'', 'owner_name'=>'', 'inn'=>'', 'site'=>'',
                'trade_place_category_id'=>1],
            ['name'=>'', 'owner_name'=>'', 'inn'=>'', 'site'=>'',
                'trade_place_category_id'=>1],
            ['name'=>'', 'owner_name'=>'', 'inn'=>'', 'site'=>'',
                'trade_place_category_id'=>1],
        ];

        foreach($tradePlaces as $tradePlace){
            TradePlace::create([
               'name'=>$tradePlace['name'],
               'owner_name'=>$tradePlace['owner_name'],
               'inn'=>$tradePlace['inn'],
               'site'=>$tradePlace['site'],
               'trade_place_category_id'=>$tradePlace['trade_place_category_id']
            ]);
        }
    }
}
