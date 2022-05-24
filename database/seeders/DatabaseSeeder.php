<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AuctionTypeSeeder::class,
            BidderCategorySeeder::class,
            BidderTypeSeeder::class,
            EventTypeSeeder::class,
            NotificationTypeGroupSeeder::class,
            NotificationTypeSeeder::class,
            RegistryNotificationTypeSeeder::class,
            StatusSeeder::class
        ]);
    }
}
