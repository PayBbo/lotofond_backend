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
            ['description' => 'Открытый аукцион', 'title' => 'OpenAuction'],
            ['description' => 'Открытый конкурс', 'title' => 'OpenConcours'],
            ['description' => 'Публичное предложение', 'title' => 'PublicOffer'],
            ['description' => 'Закрытый аукцион', 'title' => 'CloseAuction'],
            ['description' => 'Закрытый конкурс', 'title' => 'CloseConcours'],
            ['description' => 'Закрытое публичное предложение', 'title' => 'ClosePublicOffer'],
        ];
        foreach ($types as $type) {
            AuctionType::create([
                'title' => $type['title'],
                'description' => $type['description']
            ]);
        }
    }
}
