<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'platform',
            'favourite',
            'monitoring'
        ];
        foreach($types as $type){
            NotificationType::create([
                'title'=>$type
            ]);
        }
    }
}
