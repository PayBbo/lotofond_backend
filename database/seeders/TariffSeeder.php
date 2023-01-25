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
                    'ru' => [
                        'Просмотр полной и подробной информации по лоту',
                        'Расширенный Поиск по всем лотам (по ключевому слову, по цене, региону, категориям, АУ, ОТ, ЭТП) - ежедневное обновление базы',
                        'Доступ к разделам: Должники, Арбитражные управляющие, Организаторы торгов',
                        'Мониторинг лотов',
                        'Мониторинг Должников, Арбитражных управляющих, Организаторов торгов',
                        'Возможность добавления лота в избранное',
                        'Возможность перехода по прямой ссылке любого лота на ЭТП или ЕФРСБ',
                        'Возможность создания собственных заметок по лоту',
                        'Рейтинг АУ и ОТ',
                        'Аналитика победителей',
                        'Поиск выигранных лотов',
                        'Планировщик',
                        'Напоминания по важным торгам / лотам ',
                        'Отправка запроса Организатору торгов',
                        'Документы и фотографии, полученные от Организатора торгов',
                        'Возможность подключения к телеграмм каналу с новыми лотами по конкретному региону',
                        'Возможность заказа отчетов ЕГРН',
                        'Возможность заказа иных отчетов по проверке недвижимости и транспорта'
                    ],
                    'en' => [
                        'View full and detailed lot information',
                        'Advanced search for all lots (by keyword, by price, region, categories, AU, OT, etc.) - daily database update',
                        'Access to sections: Debtors, Arbitration Managers, Bidders',
                        'Monitoring lots',
                        'Monitoring of Debtors, Arbitration Managers, Bidders',
                        'The ability to add a lot to favorites',
                        'The ability to follow the direct link of any lot to the ETP or the EFRSB',
                        'The ability to create your own notes on the lot',
                        'AU and OT rating',
                        'Winners analytics',
                        'Search for won lots',
                        'Scheduler',
                        'Reminders for important trades/lots ',
                        'Sending a request to the Organizer of the auction',
                        'Documents and photos received from the Organizer of the auction',
                        'The ability to connect to the telegram channel with new lots for a specific region',
                        'Possibility of ordering EGRN reports',
                        'The possibility of ordering other reports on the inspection of real estate and transport'],
                    'zh_CN' => [
                        "查看完整和详细的地段资料",
                        "高级搜索所有批次（按关键字，按价格，地区，类别，AU，OT等。)-每日数据库更新",
                        "进入部分：债务人、仲裁经理、投标人",
                        "监察地段",
                        '监测债务人、仲裁经理、投标人',
                        "在收藏夹中添加很多东西的能力",
                        "能够跟踪任何地段与ETP或EFRSB的直接联系",
                        "在拍品上创建自己笔记的能力",
                        'AU和OT评级',
                        "赢家分析",
                        "搜寻赢取的地段",
                        '调度程序',
                        "重要交易/批次提醒",
                        '向拍卖组织者发送请求',
                        "从拍卖组织者收到的文件和照片",
                        "连接到电报频道的能力与一个特定地区的新地段",
                        "订购EGRN报告的可能性",
                        '订购房地产和运输检查的其他报告的可能性'
                    ]
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
                    'ru' => [
                        'Просмотр полной и подробной информации по лоту',
                        'Расширенный Поиск по всем лотам (по ключевому слову, по цене, региону, категориям, АУ, ОТ, ЭТП) - ежедневное обновление базы',
                        'Доступ к разделам: Должники, Арбитражные управляющие, Организаторы торгов',
                        'Мониторинг лотов',
                        'Мониторинг Должников, Арбитражных управляющих, Организаторов торгов',
                        'Возможность добавления лота в избранное',
                        'Возможность перехода по прямой ссылке любого лота на ЭТП или ЕФРСБ',
                        'Возможность создания собственных заметок по лоту',
                        'Рейтинг АУ и ОТ',
                        'Аналитика победителей',
                        'Поиск выигранных лотов',
                        'Планировщик',
                        'Напоминания по важным торгам / лотам ',
                        'Отправка запроса Организатору торгов',
                        'Документы и фотографии, полученные от Организатора торгов',
                        'Возможность подключения к телеграмм каналу с новыми лотами по конкретному региону',
                        'Возможность заказа отчетов ЕГРН',
                        'Возможность заказа иных отчетов по проверке недвижимости и транспорта'
                    ],
                    'en' => [
                        'View full and detailed lot information',
                        'Advanced search for all lots (by keyword, by price, region, categories, AU, OT, etc.) - daily database update',
                        'Access to sections: Debtors, Arbitration Managers, Bidders',
                        'Monitoring lots',
                        'Monitoring of Debtors, Arbitration Managers, Bidders',
                        'The ability to add a lot to favorites',
                        'The ability to follow the direct link of any lot to the ETP or the EFRSB',
                        'The ability to create your own notes on the lot',
                        'AU and OT rating',
                        'Winners analytics',
                        'Search for won lots',
                        'Scheduler',
                        'Reminders for important trades/lots ',
                        'Sending a request to the Organizer of the auction',
                        'Documents and photos received from the Organizer of the auction',
                        'The ability to connect to the telegram channel with new lots for a specific region',
                        'Possibility of ordering EGRN reports',
                        'The possibility of ordering other reports on the inspection of real estate and transport'],
                    'zh_CN' => [
                        "查看完整和详细的地段资料",
                        "高级搜索所有批次（按关键字，按价格，地区，类别，AU，OT等。)-每日数据库更新",
                        "进入部分：债务人、仲裁经理、投标人",
                        "监察地段",
                        '监测债务人、仲裁经理、投标人',
                        "在收藏夹中添加很多东西的能力",
                        "能够跟踪任何地段与ETP或EFRSB的直接联系",
                        "在拍品上创建自己笔记的能力",
                        'AU和OT评级',
                        "赢家分析",
                        "搜寻赢取的地段",
                        '调度程序',
                        "重要交易/批次提醒",
                        '向拍卖组织者发送请求',
                        "从拍卖组织者收到的文件和照片",
                        "连接到电报频道的能力与一个特定地区的新地段",
                        "订购EGRN报告的可能性",
                        '订购房地产和运输检查的其他报告的可能性'
                    ]
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
                    'ru' => [
                        'Просмотр полной и подробной информации по лоту',
                        'Расширенный Поиск по всем лотам (по ключевому слову, по цене, региону, категориям, АУ, ОТ, ЭТП) - ежедневное обновление базы',
                        'Доступ к разделам: Должники, Арбитражные управляющие, Организаторы торгов',
                        'Мониторинг лотов',
                        'Мониторинг Должников, Арбитражных управляющих, Организаторов торгов',
                        'Возможность добавления лота в избранное',
                        'Возможность перехода по прямой ссылке любого лота на ЭТП или ЕФРСБ',
                        'Возможность создания собственных заметок по лоту',
                        'Рейтинг АУ и ОТ',
                        'Аналитика победителей',
                        'Поиск выигранных лотов',
                        'Планировщик',
                        'Напоминания по важным торгам / лотам ',
                        'Отправка запроса Организатору торгов',
                        'Документы и фотографии, полученные от Организатора торгов',
                        'Возможность подключения к телеграмм каналу с новыми лотами по конкретному региону',
                        'Возможность заказа отчетов ЕГРН',
                        'Возможность заказа иных отчетов по проверке недвижимости и транспорта'
                    ],
                    'en' => [
                        'View full and detailed lot information',
                        'Advanced search for all lots (by keyword, by price, region, categories, AU, OT, etc.) - daily database update',
                        'Access to sections: Debtors, Arbitration Managers, Bidders',
                        'Monitoring lots',
                        'Monitoring of Debtors, Arbitration Managers, Bidders',
                        'The ability to add a lot to favorites',
                        'The ability to follow the direct link of any lot to the ETP or the EFRSB',
                        'The ability to create your own notes on the lot',
                        'AU and OT rating',
                        'Winners analytics',
                        'Search for won lots',
                        'Scheduler',
                        'Reminders for important trades/lots ',
                        'Sending a request to the Organizer of the auction',
                        'Documents and photos received from the Organizer of the auction',
                        'The ability to connect to the telegram channel with new lots for a specific region',
                        'Possibility of ordering EGRN reports',
                        'The possibility of ordering other reports on the inspection of real estate and transport'],
                    'zh_CN' => [
                        "查看完整和详细的地段资料",
                        "高级搜索所有批次（按关键字，按价格，地区，类别，AU，OT等。)-每日数据库更新",
                        "进入部分：债务人、仲裁经理、投标人",
                        "监察地段",
                        '监测债务人、仲裁经理、投标人',
                        "在收藏夹中添加很多东西的能力",
                        "能够跟踪任何地段与ETP或EFRSB的直接联系",
                        "在拍品上创建自己笔记的能力",
                        'AU和OT评级',
                        "赢家分析",
                        "搜寻赢取的地段",
                        '调度程序',
                        "重要交易/批次提醒",
                        '向拍卖组织者发送请求',
                        "从拍卖组织者收到的文件和照片",
                        "连接到电报频道的能力与一个特定地区的新地段",
                        "订购EGRN报告的可能性",
                        '订购房地产和运输检查的其他报告的可能性'
                    ]
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
                    'ru' => [
                        'Просмотр полной и подробной информации по лоту',
                        'Расширенный Поиск по всем лотам (по ключевому слову, по цене, региону, категориям, АУ, ОТ, ЭТП) - ежедневное обновление базы',
                        'Доступ к разделам: Должники, Арбитражные управляющие, Организаторы торгов',
                        'Мониторинг лотов',
                        'Мониторинг Должников, Арбитражных управляющих, Организаторов торгов',
                        'Возможность добавления лота в избранное',
                        'Возможность перехода по прямой ссылке любого лота на ЭТП или ЕФРСБ',
                        'Возможность создания собственных заметок по лоту',
                        'Рейтинг АУ и ОТ',
                        'Аналитика победителей',
                        'Поиск выигранных лотов',
                        'Планировщик',
                        'Напоминания по важным торгам / лотам ',
                        'Отправка запроса Организатору торгов',
                        'Документы и фотографии, полученные от Организатора торгов',
                        'Возможность подключения к телеграмм каналу с новыми лотами по конкретному региону',
                        'Возможность заказа отчетов ЕГРН',
                        'Возможность заказа иных отчетов по проверке недвижимости и транспорта'
                    ],
                    'en' => [
                        'View full and detailed lot information',
                        'Advanced search for all lots (by keyword, by price, region, categories, AU, OT, etc.) - daily database update',
                        'Access to sections: Debtors, Arbitration Managers, Bidders',
                        'Monitoring lots',
                        'Monitoring of Debtors, Arbitration Managers, Bidders',
                        'The ability to add a lot to favorites',
                        'The ability to follow the direct link of any lot to the ETP or the EFRSB',
                        'The ability to create your own notes on the lot',
                        'AU and OT rating',
                        'Winners analytics',
                        'Search for won lots',
                        'Scheduler',
                        'Reminders for important trades/lots ',
                        'Sending a request to the Organizer of the auction',
                        'Documents and photos received from the Organizer of the auction',
                        'The ability to connect to the telegram channel with new lots for a specific region',
                        'Possibility of ordering EGRN reports',
                        'The possibility of ordering other reports on the inspection of real estate and transport'],
                    'zh_CN' => [
                        "查看完整和详细的地段资料",
                        "高级搜索所有批次（按关键字，按价格，地区，类别，AU，OT等。)-每日数据库更新",
                        "进入部分：债务人、仲裁经理、投标人",
                        "监察地段",
                        '监测债务人、仲裁经理、投标人',
                        "在收藏夹中添加很多东西的能力",
                        "能够跟踪任何地段与ETP或EFRSB的直接联系",
                        "在拍品上创建自己笔记的能力",
                        'AU和OT评级',
                        "赢家分析",
                        "搜寻赢取的地段",
                        '调度程序',
                        "重要交易/批次提醒",
                        '向拍卖组织者发送请求',
                        "从拍卖组织者收到的文件和照片",
                        "连接到电报频道的能力与一个特定地区的新地段",
                        "订购EGRN报告的可能性",
                        '订购房地产和运输检查的其他报告的可能性'
                    ]
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
                    ['ru' => 'Отчет ЕГРН', 'en' => 'USRN statement', 'zh_CN' => 'USRN声明'],
                'description' => ['ru' => 'Отчет ЕГРН', 'en' => 'EGRN Report', 'zh_CN' => 'EGRN报告'],
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
