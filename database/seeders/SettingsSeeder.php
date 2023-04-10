<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create(['variable'=>'trial_period', 'value'=>'90']);
        Setting::create(['variable'=>'watermark_text', 'value'=>'Лотофонд']);
        Setting::create(['variable'=>'watermark_image', 'value'=>'watermark.png']);
    }
}
