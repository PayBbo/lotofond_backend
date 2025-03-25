<?php

use App\Models\Tariff;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertIntoTariffsTable20250325 extends Migration
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
                'title' => ['ru' => 'Сайт+Бот 1 месяц', 'en' => 'Website+Bot 1 month', 'zh_CN' => 'Website+Bot 1个月'],
                'description' => ['ru' => 'Доступ на сайт и в телеграм бот на 1 месяц', 'en' => 'Basic description of the tariff', 'zh_CN' => '关税的基本描述'],
                'price' => 1900, 'admission_price' => 1048, 'period' => 30, 'store_id' => '1_month_combined',
                'type' => 'combined_tariff',
                'code' => null,
                'price_prefix' => null
            ],

            [
                'title' => ['ru' => 'Сайт+Бот 3 месяца', 'en' => 'Website+Bot 3 months', 'zh_CN' => 'Website+Bot 3个月'],
                'description' => ['ru' => 'Доступ на сайт и в телеграм бот на 3 месяца', 'en' => 'Basic description of the tariff', 'zh_CN' => '关税的基本描述'],
                'price' => 5300, 'admission_price' => 2646, 'period' => 90, 'store_id' => '3_months_combined',
                'type' => 'combined_tariff',
                'code' => null,
                'price_prefix' => null
            ],
            [
                'title' => ['ru' => 'Сайт+Бот 6 месяцев', 'en' => 'Website+Bot 6 months', 'zh_CN' => 'Website+Bot 6个月'],
                'description' => ['ru' => 'Доступ на сайт и в телеграм бот на 6 месяцев', 'en' => 'Basic description of the tariff', 'zh_CN' => '关税的基本描述'],
                'price' => 10700, 'admission_price' => 4886, 'period' => 180, 'store_id' => '6_months_combined',
                'type' => 'combined_tariff',
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
        Tariff::where('type', 'combined_tariff')->delete();
    }
}
