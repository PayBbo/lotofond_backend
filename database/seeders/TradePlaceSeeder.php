<?php

namespace Database\Seeders;

use App\Models\TradePlace;
use Illuminate\Database\Seeder;

class TradePlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tradePlaces = [
            ['name' => 'Электронная торговая площадка "Евразийская торговая площадка"', 'owner_name' => 'ООО "Евразийская торговая площадка"', 'inn' => '6455053254', 'site' => 'http://eurtp.ru/',
                'trade_place_category_id' => 1, 'email' => 'admin@eurtp.ru'],
            ['name' => 'АИСТ', 'owner_name' => 'ООО "Автоматизированная информационная система торгов"', 'inn' => null, 'site' => 'www.aistorg.ru',
                'trade_place_category_id' => 1, 'email' => 'aistorg@aistorg.ru'],
            ['name' => 'Электронная торговая площадка "ЮНИТРЕЙД" (признана несоответствующей установленным требованиям Минэкономразвития, решение от 24.12.2013)', 'owner_name' => 'ООО "Электронная торговая площадка "ЮНИТРЕЙД"', 'inn' => null, 'site' => 'www.electrontorg.ru',
                'trade_place_category_id' => 1, 'email' => 'info@electrontorg.ru'],
            ['name' => '"Агентство правовых коммуникаций" (признана несоответствующей установленным требованиям Минэкономразвития, решение от 27.01.2015)', 'owner_name' => 'ООО "Агентство правовых коммуникаций"', 'inn' => null, 'site' => 'www.apktorgi.ru',
                'trade_place_category_id' => 1, 'email' => 'info@moitender.ru'],
            ['name' => 'Открытая торговая площадка', 'owner_name' => 'ООО "Открытая торговая площадка"', 'inn' => '5001095100', 'site' => 'www.opentp.ru',
                'trade_place_category_id' => 1, 'email' => 'info@opentp.ru'],
            ['name' => 'UralBidIn', 'owner_name' => 'ООО "УралБидИн"', 'inn' => '6658371541', 'site' => 'www.uralbidin.ru',
                'trade_place_category_id' => 1, 'email' => 'notice@uralbidin.ru'],
            ['name' => 'ЭТС24', 'owner_name' => 'ФГУП "Электронные торги и безопасность"', 'inn' => null, 'site' => 'https://ets24.ru/index.php?class=Auction&action=List&AuctionType=Arrest',
                'trade_place_category_id' => 1, 'email' => 'info@ao-etb.ru'],

            ['name' => 'ГИС Торги', 'owner_name' => null, 'inn' => null, 'site' => 'https://torgi.gov.ru/new/public/lots/reg',
                'trade_place_category_id' => 3, 'email' => null],
            ['name' => 'РесТорг', 'owner_name' => 'ООО «СОДЕРИЗ»', 'inn' => null, 'site' => 'https://229etp.ru/',
                'trade_place_category_id' => 3, 'email' => 'support@229etp.ru, etorg-rb@yandex.ru'],
            ['name' => 'РТС-Тендер', 'owner_name' => 'ООО «РТС-тендер»', 'inn' => '7710357167', 'site' => 'https://www.rts-tender.ru/',
                'trade_place_category_id' => 3, 'email' => null],
            ['name' => 'АО «Сбербанк-АСТ»', 'owner_name' => 'АО «Сбербанк-АСТ»', 'inn' => '7707308480', 'site' => 'http://utp.sberbank-ast.ru',
                'trade_place_category_id' => 3, 'email' => 'info@sberbank-ast.ru'],
            ['name' => 'СОЮЗ', 'owner_name' => 'ООО "СОЮЗ"', 'inn' => '6229099150', 'site' => 'https://union-torg.ru/',
                'trade_place_category_id' => 3, 'email' => 'uniontorg.tech@gmail.com'],
            ['name' => 'РОСЭЛТОРГ', 'owner_name' => null, 'inn' => null, 'site' => 'https://www.roseltorg.ru/',
                'trade_place_category_id' => 3, 'email' => 'info@roseltorg.ru'],
            ['name' => 'ЭТП ТЭК-Торг', 'owner_name' => 'ООО ЭТП ГПБ', 'inn' => '7704824695', 'site' => 'https://www.tektorg.ru/',
                'trade_place_category_id' => 3, 'email' => 'info@etpgpb.ru'],
            ['name' => 'ЭТП ГПБ', 'owner_name' => 'ООО ЭТП ГПБ', 'inn' => '7724514910', 'site' => 'https://etpgpb.ru/',
                'trade_place_category_id' => 3, 'email' => 'info@etpgpb.ru'],
            ['name' => 'СПЕЦТОРГИ', 'owner_name' => 'Общество с ограниченной ответственностью "СПЕЦТОРГИ"', 'inn' => '7727842796', 'site' => 'https://storgi.ru/',
                'trade_place_category_id' => 3, 'email' => 'info@storgi.ru'],
            ['name' => 'БС КОНСАЛТИНГ', 'owner_name' => 'Общество с ограниченной ответственностью "БС КОНСАЛТИНГ"', 'inn' => '7727706296', 'site' => 'https://bs-torgi.ru',
                'trade_place_category_id' => 3, 'email' => 'bstorgi_service@mail.ru'],
            ['name' => 'ЛИДЕР', 'owner_name' => 'ООО «ЛИДЕР»', 'inn' => '5032331879', 'site' => 'https://sale-torg.ru/',
                'trade_place_category_id' => 3, 'email' => 'info.saletorg@gmail.com'],

        ];

        foreach ($tradePlaces as $tradePlace) {
            TradePlace::create([
                'name' => $tradePlace['name'],
                'owner_name' => $tradePlace['owner_name'],
                'inn' => $tradePlace['inn'],
                'site' => $tradePlace['site'],
                'email' => $tradePlace['email'],
                'trade_place_category_id' => $tradePlace['trade_place_category_id']
            ]);
        }
    }
}
