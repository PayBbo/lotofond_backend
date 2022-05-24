<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Событие',
            'Задачи',
            'Напоминание',
        ];
        foreach($types as $type){
            EventType::create([
                'title'=>$type
            ]);
        }
    }
}
