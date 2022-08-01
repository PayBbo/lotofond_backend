<?php

namespace Database\Seeders;

use App\Models\TextData;
use Illuminate\Database\Seeder;

class TextDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['header'=>'О нас', 'value'=>'С нашей помощью Вы можете сэкономить до 50% на торгах!
            Воспользуйтесь нашим опытом побед, чтобы избежать ошибок и сэкономить время, деньги и нервы.
            1. ЭЦП не нужна
            2. Аккредитация не нужна
            3. Заполнять документы не нужно
            С нами шансы на победу в торгах увеличиваются до 80%', 'type'=>'info'],
            ['header'=>'Помощь', 'value'=>'Задайте любой интересующий Вас вопрос, заполнив представленную ниже форму', 'type'=>'help'],
            ['header'=>'О приложении', 'value'=>'Наше приложение предоставляет возможность мониторинга динамики торгов и  своевременного отслеживания различных этапов аукциона', 'type'=>'about'],
            ['header'=>'Контакты', 'value'=>'Вы можете связаться с нами по номеру телефона - +7949 222 22 22 и по почте - test@mail.ru', 'type'=>'contacts'],
        ];

        foreach($data as $item){
            TextData::create([
                'header'=>$item['header'],
                'value'=>$item['value'],
                'type'=>$item['type'],
            ]);
        }
    }
}
