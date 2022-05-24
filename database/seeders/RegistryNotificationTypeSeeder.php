<?php

namespace Database\Seeders;

use App\Models\RegistryNotificationType;
use Illuminate\Database\Seeder;

class RegistryNotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Сообщения о результатах проведения комитета кредиторов',
            'Сообщения о результатах проведения собрания кредиторов',
            'Сообщения о собрании кредиторов',
            'Уведомления о получении требований кредитора',
            'Уведомления о проведении комитета кредиторов'
        ];
        foreach($types as $type){
            RegistryNotificationType::create([
                'title'=>$type,
                'notification_type_group_id'=>1
            ]);
        }
    }
}
