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
            DebtorCategorySeeder::class,
            RegistryNotificationGroupSeeder::class,
            NotificationTypeSeeder::class,
            RegistryNotificationTypeSeeder::class,
            StatusSeeder::class,
            CategorySeeder::class,
            RegionSeeder::class,
            ParamSeeder::class,
            UserSeeder::class,
            RoleSeeder::class,
            TextDataSeeder::class
        ]);
    }
}
