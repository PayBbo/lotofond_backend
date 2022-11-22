<?php

namespace Database\Seeders;

use App\Models\Tariff;
use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tariffs = [
            [
                'title' => ['ru' => '1 месяц', 'en' => '1 month', 'zh_CN' => '1个月'],
                'description' => ['ru' => 'Основное описание тарифа', 'en' => 'Basic description of the tariff', 'zh_CN' => '关税的基本描述'],
                'price' => 1000, 'admission_price' => 524, 'period' => 30, 'store_id' => '1_month',
                'included_details' => [
                    'ru' => ['Включаемая возможность номер 1', 'Включаемая возможность номер 2', 'Включаемая возможность номер 3'],
                    'en' => ['Enabling Capability number 1', 'Enabling Capability number 2', 'Enabling Capability number 3'],
                    'zh_CN' => ['启用能力编号1', '启用能力编号2', '启用能力编号3']
                ],
                'excluded_details' => [
                    'ru' => ['Исключаемая возможность номер 1', 'Исключаемая возможность номер 2', 'Исключаемая возможность номер 3'],
                    'en' => ['Excluded possibility number 1', 'Excluded possibility number 2', 'Excluded possibility number 3'],
                    'zh_CN' => ['排除可能性编号1', '排除可能性编号2', '排除可能性编号3']
                ]],
            [
                'title' => ['ru' => '3 месяца', 'en' => '3 months', 'zh_CN' => '3个月'],
                'description' => ['ru' => 'Основное описание тарифа', 'en' => 'Basic description of the tariff', 'zh_CN' => '关税的基本描述'],
                'price' => 2750, 'admission_price' => 1323, 'period' => 90, 'store_id' => '3_months',
                'included_details' => [
                    'ru' => ['Включаемая возможность номер 1', 'Включаемая возможность номер 2', 'Включаемая возможность номер 3'],
                    'en' => ['Enabling Capability number 1', 'Enabling Capability number 2', 'Enabling Capability number 3'],
                    'zh_CN' => ['启用能力编号1', '启用能力编号2', '启用能力编号3']
                ],
                'excluded_details' => [
                    'ru' => ['Исключаемая возможность номер 1', 'Исключаемая возможность номер 2', 'Исключаемая возможность номер 3'],
                    'en' => ['Excluded possibility number 1', 'Excluded possibility number 2', 'Excluded possibility number 3'],
                    'zh_CN' => ['排除可能性编号1', '排除可能性编号2', '排除可能性编号3']
                ]],
            [
                'title' => ['ru' => '6 месяцев', 'en' => '6 months', 'zh_CN' => '6个月'],
                'description' => ['ru' => 'Основное описание тарифа', 'en' => 'Basic description of the tariff', 'zh_CN' => '关税的基本描述'],
                'price' => 5400, 'admission_price' => 2443, 'period' => 180, 'store_id' => '6_months',
                'included_details' => [
                    'ru' => ['Включаемая возможность номер 1', 'Включаемая возможность номер 2', 'Включаемая возможность номер 3'],
                    'en' => ['Enabling Capability number 1', 'Enabling Capability number 2', 'Enabling Capability number 3'],
                    'zh_CN' => ['启用能力编号1', '启用能力编号2', '启用能力编号3']
                ],
                'excluded_details' => [
                    'ru' => ['Исключаемая возможность номер 1', 'Исключаемая возможность номер 2', 'Исключаемая возможность номер 3'],
                    'en' => ['Excluded possibility number 1', 'Excluded possibility number 2', 'Excluded possibility number 3'],
                    'zh_CN' => ['排除可能性编号1', '排除可能性编号2', '排除可能性编号3']
                ]],
            [
                'title' => ['ru' => '12 месяцев', 'en' => '12 months', 'zh_CN' => '12个月'],
                'description' => ['ru' => 'Основное описание тарифа', 'en' => 'Basic description of the tariff', 'zh_CN' => '关税的基本描述'],
                'price' => 10800, 'admission_price' => 2443, 'period' => 180, 'store_id' => '12_months',
                'included_details' => [
                    'ru' => ['Включаемая возможность номер 1', 'Включаемая возможность номер 2', 'Включаемая возможность номер 3'],
                    'en' => ['Enabling Capability number 1', 'Enabling Capability number 2', 'Enabling Capability number 3'],
                    'zh_CN' => ['启用能力编号1', '启用能力编号2', '启用能力编号3']
                ],
                'excluded_details' => [
                    'ru' => ['Исключаемая возможность номер 1', 'Исключаемая возможность номер 2', 'Исключаемая возможность номер 3'],
                    'en' => ['Excluded possibility number 1', 'Excluded possibility number 2', 'Excluded possibility number 3'],
                    'zh_CN' => ['排除可能性编号1', '排除可能性编号2', '排除可能性编号3']
                ]],
        ];
        foreach ($tariffs as $tariff)
            Tariff::create([
                'title' => $tariff['title'],
                'description' => $tariff['description'],
                'price' => $tariff['price'],
                'admission_price' => $tariff['admission_price'],
                'period' => $tariff['period'],
                'store_id' => $tariff['store_id'],
                'included_details'=>$tariff['included_details'],
                'excluded_details'=>$tariff['excluded_details']
            ]);
    }
}
