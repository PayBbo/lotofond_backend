<?php

namespace Database\Seeders;

use App\Models\BidderType;
use Illuminate\Database\Seeder;

class BidderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $types = [
           'Должник',
           'Арбитражный управляющий',
           'Организатор торгов',
           'Торговая площадка'
       ];
        foreach($types as $type){
            BidderType::create([
                'title'=>$type
            ]);
        }
    }
}
