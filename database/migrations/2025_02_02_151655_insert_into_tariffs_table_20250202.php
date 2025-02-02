<?php

use App\Models\Tariff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertIntoTariffsTable20250202 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tariffs = [
            [
                'title' => ['ru' => '1 месяц', 'en' => '1 month', 'zh_CN' => '1个月'],
                'description' => ['ru' => 'Доступ в телеграм бот на 1 месяц', 'en' => 'Basic description of the tariff', 'zh_CN' => '关税的基本描述'],
                'price' => 1000, 'admission_price' => 524, 'period' => 30, 'store_id' => '1_month_bot',
                'type' => 'bot_tariff',
                'code' => null,
                'price_prefix' => null
            ],

            [
                'title' => ['ru' => '3 месяца', 'en' => '3 months', 'zh_CN' => '3个月'],
                'description' => ['ru' => 'Доступ в телеграм бот на 3 месяца', 'en' => 'Basic description of the tariff', 'zh_CN' => '关税的基本描述'],
                'price' => 2750, 'admission_price' => 1323, 'period' => 90, 'store_id' => '3_months_bot',
                'type' => 'bot_tariff',
                'code' => null,
                'price_prefix' => null
            ],
            [
                'title' => ['ru' => '6 месяцев', 'en' => '6 months', 'zh_CN' => '6个月'],
                'description' => ['ru' => 'Доступ в телеграм бот на 6 месяцев', 'en' => 'Basic description of the tariff', 'zh_CN' => '关税的基本描述'],
                'price' => 5400, 'admission_price' => 2443, 'period' => 180, 'store_id' => '6_months_bot',
                'type' => 'bot_tariff',
                'code' => null,
                'price_prefix' => null
            ],

        ];
        foreach ($tariffs as $tariff)
            Tariff::create([
                'title' => $tariff['title'],
                'description' => $tariff['description'],
                'price' => $tariff['price'],
                'admission_price' => $tariff['admission_price'],
                'period' => $tariff['period'],
                'store_id' => $tariff['store_id'],
                'code' => $tariff['code'],
                'type' => $tariff['type'],
                'price_prefix' => $tariff['price_prefix'],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Tariff::where('type', 'bot_tariff')->delete();
    }
}
