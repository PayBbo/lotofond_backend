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
                ],
                'type' => 'tariff',
                'code' => null,
                'price_prefix' => null
            ],

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
                ],
                'type' => 'tariff',
                'code' => null,
                'price_prefix' => null
            ],
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
                ],
                'type' => 'tariff',
                'code' => null,
                'price_prefix' => null
            ],
            [
                'title' => ['ru' => '12 месяцев', 'en' => '12 months', 'zh_CN' => '12个月'],
                'description' => ['ru' => 'Основное описание тарифа', 'en' => 'Basic description of the tariff', 'zh_CN' => '关税的基本描述'],
                'price' => 10800, 'admission_price' => 2443, 'period' => 365, 'store_id' => '12_months',
                'included_details' => [
                    'ru' => ['Включаемая возможность номер 1', 'Включаемая возможность номер 2', 'Включаемая возможность номер 3'],
                    'en' => ['Enabling Capability number 1', 'Enabling Capability number 2', 'Enabling Capability number 3'],
                    'zh_CN' => ['启用能力编号1', '启用能力编号2', '启用能力编号3']
                ],
                'excluded_details' => [
                    'ru' => ['Исключаемая возможность номер 1', 'Исключаемая возможность номер 2', 'Исключаемая возможность номер 3'],
                    'en' => ['Excluded possibility number 1', 'Excluded possibility number 2', 'Excluded possibility number 3'],
                    'zh_CN' => ['排除可能性编号1', '排除可能性编号2', '排除可能性编号3']
                ],
                'type' => 'tariff',
                'code' => null,
                'price_prefix' => null
            ],

            [
                'title' =>
                    [
                        'ru' => 'Покупка без ЭЦП - инструкция',
                        'en' => 'Purchase without EDS - instructions',
                        'zh_CN' => '购买没有EDS-说明'
                    ],
                'description' => ['ru' => 'Инструкция для проведения торгов', 'en' => 'Instructions for bidding', 'zh_CN' => '投标须知'],
                'code' => 'purchaseInstructions',
                'price' => 3000,
                'price_prefix' => 'от',
                'admission_price' => null,
                'period' => null,
                'store_id' => null,
                'included_details' => null,
                'excluded_details' => null,
                'type' => 'service'
            ],
            [
                'title' =>
                    [
                        'ru' => 'Покупка без ЭЦП – проведение торгов',
                        'en' => 'Purchase without EDS - bidding',
                        'zh_CN' => '购买无EDS-投标'
                    ],
                'description' => ['ru' => 'Проведение торгов нашими специалистами вместо вас', 'en' => 'Bidding by our specialists instead of you', 'zh_CN' => '由我们的专家代替你投标'],
                'code' => 'purchaseBidByAgent',
                'price' => 10000,
                'price_prefix' => 'от',
                'admission_price' => null,
                'period' => null,
                'store_id' => null,
                'included_details' => null,
                'excluded_details' => null,
                'type' => 'service'
            ],
            [
                'title' =>
                    ['ru' => 'Выписка ЕГРН', 'en' => 'USRN statement', 'zh_CN' => 'USRN声明'],
                'description' =>['ru' => 'Выписка ЕГРН', 'en' => 'USRN statement', 'zh_CN' => 'USRN声明'],
                'code' => 'receiptEGRN',
                'price' => 70,
                'price_prefix' => null,
                'admission_price' => null,
                'period' => null,
                'store_id' => null,
                'included_details' => null,
                'excluded_details' => null,
                'type' => 'service'
            ],
            [
                'title' =>
                    ['ru' => 'Сбор информации по лоту', 'en' => 'Collection of lot information (liquidity assessment)', 'zh_CN' => '收集地段资料(流动资金评估)'],
                'description' => ['ru' => 'Оценка ликвидности выбранного лота нашими сотрудниками', 'en' => 'Assessment of the liquidity of the selected lot by our employees', 'zh_CN' => '我们的员工对所选地段的流动性进行评估'],
                'code' => 'infoAboutLot',
                'price' => 3000,
                'price_prefix' => 'от',
                'admission_price' => null,
                'period' => null,
                'store_id' => null,
                'included_details' => null,
                'excluded_details' => null,
                'type' => 'service'
            ],
            [
                'title' =>
                    ['ru' => 'Консультация по лоту', 'en' => 'Consultation on the lot', 'zh_CN' => '有关地段的谘询'],
                'description' => ['ru' => 'Юридическая консультация по выбранному лоту', 'en' => 'Legal advice on the selected lot', 'zh_CN' => '就选定地段提供法律意见'],
                'code' => 'consultation',
                'price' => 5000,
                'price_prefix' => 'от',
                'admission_price' => null,
                'period' => null,
                'store_id' => null,
                'included_details' => null,
                'excluded_details' => null,
                'type' => 'service'
            ],
            [
                'title' =>
                    ['ru' => 'Сопровождение в ФАС', 'en' => 'Support in the FAS', 'zh_CN' => 'FAS中的支持'],
                'description' => ['ru' => 'Сопровождение в Федеральной Антимонопольной службе', 'en' => 'Support in the Federal Antimonopoly Service', 'zh_CN' => '联邦反垄断局的支持'],
                'code' => 'accompanimentFAS',
                'price' => 9000,
                'price_prefix' => 'от',
                'admission_price' => null,
                'period' => null,
                'store_id' => null,
                'included_details' => null,
                'excluded_details' => null,
                'type' => 'service'
            ],
            [
                'title' =>
                    ['ru' => 'Новый вопрос', 'en' => 'New question', 'zh_CN' => '新问题'],
                'description' => null,
                'code' => 'newQuestion',
                'price' => null,
                'price_prefix' => null,
                'admission_price' => null,
                'period' => null,
                'store_id' => null,
                'included_details' => null,
                'excluded_details' => null,
                'type' => 'system'
            ]

        ];
        foreach ($tariffs as $tariff)
            Tariff::create([
                'title' => $tariff['title'],
                'description' => $tariff['description'],
                'price' => $tariff['price'],
                'admission_price' => $tariff['admission_price'],
                'period' => $tariff['period'],
                'store_id' => $tariff['store_id'],
                'included_details' => $tariff['included_details'],
                'excluded_details' => $tariff['excluded_details'],
                'code' => $tariff['code'],
                'type' => $tariff['type'],
                'price_prefix' => $tariff['price_prefix'],
            ]);
    }
}
