<?php

namespace Database\Seeders;

use App\Models\ContentRule;
use Illuminate\Database\Seeder;

class ContentRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rules = [
            ['title' => 'Номер лота в торге', 'code' => 'lotNumber', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'Картинки', 'code' => 'photos', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'Категории', 'code' => 'categories', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'Статус лота', 'code' => 'state', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'Регионы лота', 'code' => 'location', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'Начальная цена', 'code' => 'startPrice', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'Шаг аукциона', 'code' => 'stepPrice', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'Задаток', 'code' => 'deposit', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'График снижения цены', 'code' => 'priceReduction', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'Текущая цена', 'code' => 'currentPrice', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'Минимальная цена', 'code' => 'minPrice', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'Текущее состояние цены', 'code' => 'currentPriceState', 'is_available' => true, 'type' => 'lot'],
            ['title' => 'Ссылка на лот на федресурсе', 'code' => 'efrsbLink', 'is_available' => false, 'type' => 'lot'],
            ['title' => 'Кадастровые номера, номера автомобилей и VIN', 'code' => 'descriptionExtracts', 'is_available' => false, 'type' => 'lot'],
            ['title' => 'Номер торгов', 'code' => 'externalId', 'is_available' => false, 'type' => 'trade'],
            ['title' => 'Тип торгов', 'code' => 'type', 'is_available' => true, 'type' => 'trade'],
            ['title' => 'Дата публикации', 'code' => 'publishDate', 'is_available' => true, 'type' => 'trade'],
            ['title' => 'Даты проведения торгов', 'code' => 'eventTime', 'is_available' => true, 'type' => 'trade'],
            ['title' => 'Даты приема заявок', 'code' => 'applicationTime', 'is_available' => true, 'type' => 'trade'],
            ['title' => 'Форма подачи предложения о цене', 'code' => 'priceOfferForm', 'is_available' => true, 'type' => 'trade'],
            ['title' => 'Информация по организатору', 'code' => 'organizer', 'is_available' => false, 'type' => 'trade'],
            ['title' => 'Информация по арбитражному управляющему', 'code' => 'arbitrationManager', 'is_available' => false, 'type' => 'trade'],
            ['title' => 'Информация по должнику', 'code' => 'debtor', 'is_available' => false, 'type' => 'trade'],
            ['title' => 'Информация по торговой площадке', 'code' => 'tradePlace', 'is_available' => false, 'type' => 'trade'],
            ['title' => 'Количество лотов в торге', 'code' => 'lotCount', 'is_available' => true, 'type' => 'trade'],
            ['title' => 'Документы по торгам', 'code' => 'hasAccessToTradeFiles', 'is_available' => false, 'type' => 'system'],
            ['title' => 'Доступ к мониторингу', 'code' => 'hasAccessToMonitoring', 'is_available' => false, 'type' => 'system'],
            ['title' => 'Доступ к реестру', 'code' => 'hasAccessToReestr', 'is_available' => false, 'type' => 'system'],
            ['title' => 'Доступ к избранному', 'code' => 'hasAccessToFavourite', 'is_available' => true, 'type' => 'system']
        ];

        foreach ($rules as $rule) {
            ContentRule::create([
                'title' => $rule['title'],
                'code' => $rule['code'],
                'is_available' => $rule['is_available'],
                'type' => $rule['type']
            ]);
        }
    }
}
