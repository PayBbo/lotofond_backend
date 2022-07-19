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
            ['title' => 'Амурская область', 'code' => 'AmurRegion', 'region_group_id' => 1, 'numbers'=>'28'],
            ['title' => 'Еврейская автономная область', 'code' => 'JewishAutonomousRegion', 'region_group_id' => 1, 'numbers'=>'79'],
            ['title' => 'Камчатский край', 'code' => 'KamchatkaKrai', 'region_group_id' => 1, 'numbers'=>'41'],
            ['title' => 'Магаданская область', 'code' => 'MagadanRegion', 'region_group_id' => 1, 'numbers'=>'49'],
            ['title' => 'Приморский край', 'code' => 'PrimorskyKrai', 'region_group_id' => 1, 'numbers'=>'25, 125'],
            ['title' => 'Республика Саха (Якутия)', 'code' => 'TheRepublicOfSakha', 'region_group_id' => 1, 'numbers'=>'14'],
            ['title' => 'Сахалинская область', 'code' => 'SakhalinRegion', 'region_group_id' => 1, 'numbers'=>'65'],
            ['title' => 'Хабаровский край', 'code' => 'KhabarovskRegion', 'region_group_id' => 1, 'numbers'=>'27'],
            ['title' => 'Чукотский автономный округ', 'code' => 'ChukotkaAutonomousOkrug', 'region_group_id' => 1, 'numbers'=>'87'],
            ['title' => 'Кировская область', 'code' => 'KirovRegion', 'region_group_id' => 2, 'numbers'=>'43'],
            ['title' => 'Нижегородская область', 'code' => 'NizhnyNovgorodRegion', 'region_group_id' => 2, 'numbers'=>'52, 152'],
            ['title' => 'Оренбургская область', 'code' => 'OrenburgRegion', 'region_group_id' => 2, 'numbers'=>'56'],
            ['title' => 'Пензенская область', 'code' => 'PenzaRegion', 'region_group_id' => 2, 'numbers'=>'58'],
            ['title' => 'Пермский край', 'code' => 'PermRegion', 'region_group_id' => 2, 'numbers'=>'59, 81, 159'],
            ['title' => 'Республика Башкортостан', 'code' => 'RepublicOfBashkortostan', 'region_group_id' => 2, 'numbers'=>'02, 102'],
            ['title' => 'Республика Марий Эл', 'code' => 'MariElRepublic', 'region_group_id' => 2, 'numbers'=>'12'],
            ['title' => 'Республика Мордовия', 'code' => 'TheRepublicOfMordovia', 'region_group_id' => 2, 'numbers'=>'13, 113'],
            ['title' => 'Республика Татарстан', 'code' => 'RepublicOfTatarstan', 'region_group_id' => 2, 'numbers'=>'16, 116'],
            ['title' => 'Самарская область', 'code' => 'SamaraRegion', 'region_group_id' => 2, 'numbers'=>'63, 163'],
            ['title' => 'Саратовская область', 'code' => 'SaratovRegion', 'region_group_id' => 2, 'numbers'=>'64, 164'],
            ['title' => 'Удмуртская Республика', 'code' => 'Udmurtrepublic', 'region_group_id' => 2, 'numbers'=>'18'],
            ['title' => 'Ульяновская область', 'code' => 'UlyanovskRegion', 'region_group_id' => 2, 'numbers'=>'73, 173'],
            ['title' => 'Чувашская Республика - Чувашия', 'code' => 'ChuvashRepublic', 'region_group_id' => 2, 'numbers'=>'21, 121'],
            ['title' => 'Архангельская область', 'code' => 'ArhangelskRegion', 'region_group_id' => 3, 'numbers'=>'29'],
            ['title' => 'Вологодская область', 'code' => 'VologodskayaOblast', 'region_group_id' => 3, 'numbers'=>'35'],
            ['title' => 'г. Санкт-Петербург', 'code' => 'StPetersburg', 'region_group_id' => 3, 'numbers'=>'78, 98, 178'],
            ['title' => 'Калининградская область', 'code' => 'KaliningradRegion', 'region_group_id' => 3, 'numbers'=>'39, 91'],
            ['title' => 'Ленинградская область', 'code' => 'LeningradRegion', 'region_group_id' => 3, 'numbers'=>'47'],
            ['title' => 'Мурманская область', 'code' => 'MurmanskRegion', 'region_group_id' => 3, 'numbers'=>'51'],
            ['title' => 'Ненецкий автономный округ', 'code' => 'NenetsAutonomousOkrug', 'region_group_id' => 3, 'numbers'=>'83'],
            ['title' => 'Новгородская область', 'code' => 'NovgorodRegion', 'region_group_id' => 3, 'numbers'=>'53'],
            ['title' => 'Псковская область', 'code' => 'PskovRegion', 'region_group_id' => 3, 'numbers'=>'60'],
            ['title' => 'Республика Карелия', 'code' => 'RepublicOfKarelia', 'region_group_id' => 3, 'numbers'=>'10'],
            ['title' => 'Республика Коми', 'code' => 'KomiRepublic', 'region_group_id' => 3, 'numbers'=>'11'],
            ['title' => 'Кабардино-Балкарская Республика', 'code' => 'KabardinoBalkarianRepublic', 'region_group_id' => 4, 'numbers'=>'07'],
            ['title' => 'Республика Дагестан', 'code' => 'TheRepublicOfDagestan', 'region_group_id' => 4, 'numbers'=>'05'],
            ['title' => 'Республика Ингушетия', 'code' => 'TheRepublicOfIngushetia', 'region_group_id' => 4, 'numbers'=>'06'],
            ['title' => 'Республика Карачаево-Черкесия', 'code' => 'RepublicOfKarachayCherkessia', 'region_group_id' => 4, 'numbers'=>'09'],
            ['title' => 'Республика Северная Осетия - Алания', 'code' => 'RepublicOfNorthOssetiaAlania', 'region_group_id' => 4, 'numbers'=>'15'],
            ['title' => 'Ставропольский край', 'code' => 'StavropolRegion', 'region_group_id' => 4, 'numbers'=>'26'],
            ['title' => 'Чеченская Республика', 'code' => 'ChechenRepublic', 'region_group_id' => 4, 'numbers'=>'20, 95'],
            ['title' => 'Алтайский край', 'code' => 'AltaiRegion', 'region_group_id' => 5, 'numbers'=>'22'],
            ['title' => 'Забайкальский край', 'code' => 'ZabaykalskyKrai', 'region_group_id' => 5, 'numbers'=>'75, 80'],
            ['title' => 'Иркутская область', 'code' => 'IrkutskRegion', 'region_group_id' => 5, 'numbers'=>'38, 138, 85'],
            ['title' => 'Кемеровская область', 'code' => 'KemerovoRegion', 'region_group_id' => 5, 'numbers'=>'42, 142'],
            ['title' => 'Красноярский край', 'code' => 'KrasnoyarskRegion', 'region_group_id' => 5, 'numbers'=>'24, 84, 88, 124'],
            ['title' => 'Новосибирская область', 'code' => 'NovosibirskRegion', 'region_group_id' => 5, 'numbers'=>'54, 154'],
            ['title' => 'Омская область', 'code' => 'OmskRegion', 'region_group_id' => 5, 'numbers'=>'55'],
            ['title' => 'Республика Алтай', 'code' => 'AltaiRepublic', 'region_group_id' => 5, 'numbers'=>'04'],
            ['title' => 'Республика Бурятия', 'code' => 'TheRepublicOfBuryatia', 'region_group_id' => 5, 'numbers'=>'03'],
            ['title' => 'Республика Тыва', 'code' => 'TyvaRepublic', 'region_group_id' => 5, 'numbers'=>'17'],
            ['title' => 'Республика Хакасия', 'code' => 'TheRepublicOfKhakassia', 'region_group_id' => 5, 'numbers'=>'19'],
            ['title' => 'Томская область', 'code' => 'TomskRegion', 'region_group_id' => 5, 'numbers'=>'70'],
            ['title' => 'Курганская область', 'code' => 'KurganRegion', 'region_group_id' => 6, 'numbers'=>'45'],
            ['title' => 'Свердловская область', 'code' => 'SverdlovskRegion', 'region_group_id' => 6, 'numbers'=>'66, 96'],
            ['title' => 'Тюменская область', 'code' => 'TyumenRegion', 'region_group_id' => 6, 'numbers'=>'72'],
            ['title' => 'Ханты-Мансийский автономный округ - Югра', 'code' => 'KhantyMansiAutonomousOkrugYugra', 'region_group_id' => 6, 'numbers'=>'86'],
            ['title' => 'Челябинская область', 'code' => 'ChelyabinskRegion', 'region_group_id' => 6, 'numbers'=>'74, 174'],
            ['title' => 'Ямало-Ненецкий автономный округ', 'code' => 'YamaloNenetsAutonomousOkrug', 'region_group_id' => 6, 'numbers'=>'89'],
            ['title' => 'Белгородская область', 'code' => 'BelgorodRegion', 'region_group_id' => 7, 'numbers'=>'31'],
            ['title' => 'Брянская область', 'code' => 'BryanskRegion', 'region_group_id' => 7, 'numbers'=>'32'],
            ['title' => 'Владимирская область', 'code' => 'VladimirRegion', 'region_group_id' => 7, 'numbers'=>'33'],
            ['title' => 'Воронежская область', 'code' => 'VoronezhRegion', 'region_group_id' => 7, 'numbers'=>'36, 136'],
            ['title' => 'г. Москва', 'code' => 'MoscowCity', 'region_group_id' => 7, 'numbers'=>'77, 97, 99, 177, 199, 197'],
            ['title' => 'Ивановская область', 'code' => 'IvanovoRegion', 'region_group_id' => 7, 'numbers'=>'37'],
            ['title' => 'Калужская область', 'code' => 'KalugaRegion', 'region_group_id' => 7, 'numbers'=>'40'],
            ['title' => 'Костромская область', 'code' => 'KostromaRegion', 'region_group_id' => 7, 'numbers'=>'44'],
            ['title' => 'Курская область', 'code' => 'KurskRegion', 'region_group_id' => 7, 'numbers'=>'46'],
            ['title' => 'Липецкая область', 'code' => 'LipetskRegion', 'region_group_id' => 7, 'numbers'=>'48'],
            ['title' => 'Московская область', 'code' => 'MoscowRegion', 'region_group_id' => 7, 'numbers'=>'50, 90, 150, 190'],
            ['title' => 'Орловская область', 'code' => 'OryolRegion', 'region_group_id' => 7, 'numbers'=>'57'],
            ['title' => 'Рязанская область', 'code' => 'RyazanOblast', 'region_group_id' => 7, 'numbers'=>'62'],
            ['title' => 'Смоленская область', 'code' => 'SmolenskRegion', 'region_group_id' => 7, 'numbers'=>'67'],
            ['title' => 'Тамбовская область', 'code' => 'TambovRegion', 'region_group_id' => 7, 'numbers'=>'68'],
            ['title' => 'Тверская область', 'code' => 'TverRegion', 'region_group_id' => 7, 'numbers'=>'69'],
            ['title' => 'Тульская область', 'code' => 'TulaRegion', 'region_group_id' => 7, 'numbers'=>'71'],
            ['title' => 'Ярославская область', 'code' => 'YaroslavlRegion', 'region_group_id' => 7, 'numbers'=>'76'],
            ['title' => 'Астраханская область', 'code' => 'AstrakhanRegion', 'region_group_id' => 8, 'numbers'=>'30'],
            ['title' => 'Волгоградская область', 'code' => 'VolgogradRegion', 'region_group_id' => 8, 'numbers'=>'34'],
            ['title' => 'г. Севастополь', 'code' => 'Sevastopol', 'region_group_id' => 8, 'numbers'=>'92'],
            ['title' => 'Краснодарский край', 'code' => 'KrasnodarRegion', 'region_group_id' => 8, 'numbers'=>'23, 93, 123'],
            ['title' => 'Республика Адыгея', 'code' => 'RepublicOfAdygea', 'region_group_id' => 8, 'numbers'=>'01'],
            ['title' => 'Республика Калмыкия', 'code' => 'RepublicOfKalmykia', 'region_group_id' => 8, 'numbers'=>'08'],
            ['title' => 'Республика Крым', 'code' => 'RepublicOfCrimea', 'region_group_id' => 8, 'numbers'=>'82'],
            ['title' => 'Ростовская область', 'code' => 'RostovRegion', 'region_group_id' => 8, 'numbers'=>'61, 161']

        ];

        foreach ($regions as $region) {
            Region::create([
                'title' => $region['title'],
                'code' => $region['code'],
                'region_group_id' => $region['region_group_id'],
                'numbers'=>$region['numbers']
            ]);
        }
    }
}
