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
            CategorySeeder::class,
            ContactSeeder::class,
            ContentRuleSeeder::class,
            DebtorCategorySeeder::class,
            HolidayDateSeeder::class,
            NotificationTypeSeeder::class,
            ParamSeeder::class,
            PermissionSeeder::class,
            RegionSeeder::class,
            RegistryNotificationGroupSeeder::class,
            RegistryNotificationTypeSeeder::class,
            RoleSeeder::class,
            StatusSeeder::class,
            TariffSeeder::class,
            TextDataSeeder::class,
            TradePlaceCategorySeeder::class,
            TradePlaceSeeder::class,
            UserSeeder::class

        ]);
    }
}
