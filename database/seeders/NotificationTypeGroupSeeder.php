<?php

namespace Database\Seeders;

use App\Models\NotificationTypeGroup;
use Illuminate\Database\Seeder;

class NotificationTypeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Собрания и комитеты кредиторов',
            'Сведения об активах',
            'Сообщения для участников строительства',
            'Организация и проведение реализации имущества',
            'Собрание работников должника',
            'Оспаривание сделки',
            'Ответственность контролирующих лиц',
            'Сообщения по финансовым организациям',
            'Сообщения судебного пристава',
            'Сведения об исполнении плана реструктуризации',
            'Признаки преднамеренного или фиктивного банкротства',
            'Другие уведомления',
        ];
        foreach($types as $type){
            NotificationTypeGroup::create([
                'title'=>$type
            ]);
        }
    }
}
