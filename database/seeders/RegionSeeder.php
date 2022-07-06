<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\RegionGroup;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            'farEastFO',
            'privolzhFO',
            'northWestFO',
            'northCaucasFO',
            'siberianFO',
            'uralFO',
            'centralFO',
            'southFO'
        ];
        foreach ($groups as $group) {
            RegionGroup::create([
                'title' => $group
            ]);
        }
        $regions = [
            ['title' => 'Амурская область', 'code' => 'AmurRegion', 'region_group_id' => 1],
            ['title' => 'Еврейская автономная область', 'code' => 'JewishAutonomousRegion', 'region_group_id' => 1],
            ['title' => 'Камчатский край', 'code' => 'KamchatkaKrai', 'region_group_id' => 1],
            ['title' => 'Магаданская область', 'code' => 'MagadanRegion', 'region_group_id' => 1],
            ['title' => 'Приморский край', 'code' => 'PrimorskyKrai', 'region_group_id' => 1],
            ['title' => 'Республика Саха (Якутия)', 'code' => 'TheRepublicOfSakha', 'region_group_id' => 1],
            ['title' => 'Сахалинская область', 'code' => 'SakhalinRegion', 'region_group_id' => 1],
            ['title' => 'Хабаровский край', 'code' => 'KhabarovskRegion', 'region_group_id' => 1],
            ['title' => 'Чукотский автономный округ', 'code' => 'ChukotkaAutonomousOkrug', 'region_group_id' => 1],
            ['title' => 'Кировская область', 'code' => 'KirovRegion', 'region_group_id' => 2],
            ['title' => 'Нижегородская область', 'code' => 'NizhnyNovgorodRegion', 'region_group_id' => 2],
            ['title' => 'Оренбургская область', 'code' => 'OrenburgRegion', 'region_group_id' => 2],
            ['title' => 'Пензенская область', 'code' => 'PenzaRegion', 'region_group_id' => 2],
            ['title' => 'Пермский край', 'code' => 'PermRegion', 'region_group_id' => 2],
            ['title' => 'Республика Башкортостан', 'code' => 'RepublicOfBashkortostan', 'region_group_id' => 2],
            ['title' => 'Республика Марий Эл', 'code' => 'MariElRepublic', 'region_group_id' => 2],
            ['title' => 'Республика Мордовия', 'code' => 'TheRepublicOfMordovia', 'region_group_id' => 2],
            ['title' => 'Республика Татарстан', 'code' => 'RepublicOfTatarstan', 'region_group_id' => 2],
            ['title' => 'Самарская область', 'code' => 'SamaraRegion', 'region_group_id' => 2],
            ['title' => 'Саратовская область', 'code' => 'SaratovRegion', 'region_group_id' => 2],
            ['title' => 'Удмуртская Республика', 'code' => 'Udmurtrepublic', 'region_group_id' => 2],
            ['title' => 'Ульяновская область', 'code' => 'UlyanovskRegion', 'region_group_id' => 2],
            ['title' => 'Чувашская Республика', 'code' => 'ChuvashRepublic', 'region_group_id' => 2],
            ['title' => 'Архангельская область', 'code' => 'ArhangelskRegion', 'region_group_id' => 3],
            ['title' => 'Вологодская область', 'code' => 'VologodskayaOblast', 'region_group_id' => 3],
            ['title' => 'г. Санкт-Петербург', 'code' => 'StPetersburg', 'region_group_id' => 3],
            ['title' => 'Калининградская область', 'code' => 'KaliningradRegion', 'region_group_id' => 3],
            ['title' => 'Ленинградская область', 'code' => 'LeningradRegion', 'region_group_id' => 3],
            ['title' => 'Мурманская область', 'code' => 'MurmanskRegion', 'region_group_id' => 3],
            ['title' => 'Ненецкий автономный округ', 'code' => 'NenetsAutonomousOkrug', 'region_group_id' => 3],
            ['title' => 'Новгородская область', 'code' => 'NovgorodRegion', 'region_group_id' => 3],
            ['title' => 'Псковская область', 'code' => 'PskovRegion', 'region_group_id' => 3],
            ['title' => 'Республика Карелия', 'code' => 'RepublicOfKarelia', 'region_group_id' => 3],
            ['title' => 'Республика Коми', 'code' => 'KomiRepublic', 'region_group_id' => 3],
            ['title' => 'Кабардино-Балкарская Республика', 'code' => 'KabardinoBalkarianRepublic', 'region_group_id' => 4],
            ['title' => 'Республика Дагестан', 'code' => 'TheRepublicOfDagestan', 'region_group_id' => 4],
            ['title' => 'Республика Ингушетия', 'code' => 'TheRepublicOfIngushetia', 'region_group_id' => 4],
            ['title' => 'Республика Карачаево-Черкесия', 'code' => 'RepublicOfKarachayCherkessia', 'region_group_id' => 4],
            ['title' => 'Республика Северная Осетия-Алания', 'code' => 'RepublicOfNorthOssetiaAlania', 'region_group_id' => 4],
            ['title' => 'Ставропольский край', 'code' => 'StavropolRegion', 'region_group_id' => 4],
            ['title' => 'Чеченская Республика', 'code' => 'ChechenRepublic', 'region_group_id' => 4],
            ['title' => 'Алтайский край', 'code' => 'AltaiRegion', 'region_group_id' => 5],
            ['title' => 'Забайкальский край', 'code' => 'ZabaykalskyKrai', 'region_group_id' => 5],
            ['title' => 'Иркутская область', 'code' => 'IrkutskRegion', 'region_group_id' => 5],
            ['title' => 'Кемеровская область', 'code' => 'KemerovoRegion', 'region_group_id' => 5],
            ['title' => 'Красноярский край', 'code' => 'KrasnoyarskRegion', 'region_group_id' => 5],
            ['title' => 'Новосибирская область', 'code' => 'NovosibirskRegion', 'region_group_id' => 5],
            ['title' => 'Омская область', 'code' => 'OmskRegion', 'region_group_id' => 5],
            ['title' => 'Республика Алтай', 'code' => 'AltaiRepublic', 'region_group_id' => 5],
            ['title' => 'Республика Бурятия', 'code' => 'TheRepublicOfBuryatia', 'region_group_id' => 5],
            ['title' => 'Республика Тыва', 'code' => 'TyvaRepublic', 'region_group_id' => 5],
            ['title' => 'Республика Хакасия', 'code' => 'TheRepublicOfKhakassia', 'region_group_id' => 5],
            ['title' => 'Томская область', 'code' => 'TomskRegion', 'region_group_id' => 5],
            ['title' => 'Курганская область', 'code' => 'KurganRegion', 'region_group_id' => 6],
            ['title' => 'Свердловская область', 'code' => 'SverdlovskRegion', 'region_group_id' => 6],
            ['title' => 'Тюменская область', 'code' => 'TyumenRegion', 'region_group_id' => 6],
            ['title' => 'Ханты-Мансийский автономный округ - Югра', 'code' => 'KhantyMansiAutonomousOkrugYugra', 'region_group_id' => 6],
            ['title' => 'Челябинская область', 'code' => 'ChelyabinskRegion', 'region_group_id' => 6],
            ['title' => 'Ямало-Ненецкий автономный округ', 'code' => 'YamaloNenetsAutonomousOkrug', 'region_group_id' => 6],
            ['title' => 'Белгородская область', 'code' => 'BelgorodRegion', 'region_group_id' => 7],
            ['title' => 'Брянская область', 'code' => 'BryanskRegion', 'region_group_id' => 7],
            ['title' => 'Владимирская область', 'code' => 'VladimirRegion', 'region_group_id' => 7],
            ['title' => 'Воронежская область', 'code' => 'VoronezhRegion', 'region_group_id' => 7],
            ['title' => 'г. Москва', 'code' => 'MoscowCity', 'region_group_id' => 7],
            ['title' => 'Ивановская область', 'code' => 'IvanovoRegion', 'region_group_id' => 7],
            ['title' => 'Калужская область', 'code' => 'KalugaRegion', 'region_group_id' => 7],
            ['title' => 'Костромская область', 'code' => 'KostromaRegion', 'region_group_id' => 7],
            ['title' => 'Курская область', 'code' => 'KurskRegion', 'region_group_id' => 7],
            ['title' => 'Липецкая область', 'code' => 'LipetskRegion', 'region_group_id' => 7],
            ['title' => 'Московская область', 'code' => 'MoscowRegion', 'region_group_id' => 7],
            ['title' => 'Орловская область', 'code' => 'OryolRegion', 'region_group_id' => 7],
            ['title' => 'Рязанская область', 'code' => 'RyazanOblast', 'region_group_id' => 7],
            ['title' => 'Смоленская область', 'code' => 'SmolenskRegion', 'region_group_id' => 7],
            ['title' => 'Тамбовская область', 'code' => 'TambovRegion', 'region_group_id' => 7],
            ['title' => 'Тверская область', 'code' => 'TverRegion', 'region_group_id' => 7],
            ['title' => 'Тульская область', 'code' => 'TulaRegion', 'region_group_id' => 7],
            ['title' => 'Ярославская область', 'code' => 'YaroslavlRegion', 'region_group_id' => 7],
            ['title' => 'Астраханская область', 'code' => 'AstrakhanRegion', 'region_group_id' => 8],
            ['title' => 'Волгоградская область', 'code' => 'VolgogradRegion', 'region_group_id' => 8],
            ['title' => 'г.Севастополь', 'code' => 'Sevastopol', 'region_group_id' => 8],
            ['title' => 'Краснодарский край', 'code' => 'KrasnodarRegion', 'region_group_id' => 8],
            ['title' => 'Республика Адыгея', 'code' => 'RepublicOfAdygea', 'region_group_id' => 8],
            ['title' => 'Республика Калмыкия', 'code' => 'RepublicOfKalmykia', 'region_group_id' => 8],
            ['title' => 'Республика Крым', 'code' => 'RepublicOfCrimea', 'region_group_id' => 8],
            ['title' => 'Ростовская область', 'code' => 'RostovRegion', 'region_group_id' => 8]

        ];

        foreach ($regions as $region) {
            Region::create([
                'title' => $region['title'],
                'code' => $region['code'],
                'region_group_id' => $region['region_group_id']
            ]);
        }
    }
}
