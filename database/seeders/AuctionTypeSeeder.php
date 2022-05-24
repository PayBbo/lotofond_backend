<?php

namespace Database\Seeders;

use App\Models\AuctionType;
use Illuminate\Database\Seeder;

class AuctionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Открытый аукцион',
            'Открытый конкурс',
            'Публичное предложение',
            'Закрытый аукцион',
            'Закрытый конкурс',
            'Закрытое публичное предложение'
        ];
        foreach($types as $type){
            AuctionType::create([
                'title'=>$type
            ]);
        }
    }
}
