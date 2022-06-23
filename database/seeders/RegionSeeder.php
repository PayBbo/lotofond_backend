<?php

namespace Database\Seeders;

use App\Models\Region;
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
        $regions = [
            ['title' => 'Амурская область', 'code' => 'AmurRegion'],
            ['title' => 'Еврейская автономная область', 'code' => 'JewishAutonomousRegion'],
            ['title' => 'Камчатский край', 'code' => 'KamchatkaKrai'],
            ['title' => 'Магаданская область', 'code' => 'MagadanRegion'],
            ['title' => 'Приморский край', 'code' => 'PrimorskyKrai'],
            ['title' => 'Республика Саха (Якутия)', 'code' => 'TheRepublicOfSakha'],
            ['title' => 'Сахалинская область', 'code' => 'SakhalinRegion'],
            ['title' => 'Хабаровский край', 'code' => 'KhabarovskRegion'],
            ['title' => 'Чукотский автономный округ', 'code' => 'ChukotkaAutonomousOkrug'],
            ['title' => 'Кировская область', 'code' => 'KirovRegion'],
            ['title' => 'Нижегородская область', 'code' => 'NizhnyNovgorodRegion'],
            ['title' => 'Оренбургская область', 'code' => 'OrenburgRegion'],
            ['title' => 'Пензенская область', 'code' => 'PenzaRegion'],
            ['title' => 'Пермский край', 'code' => 'PermRegion'],
            ['title' => 'Республика Башкортостан', 'code' => 'RepublicOfBashkortostan'],
            ['title' => 'Республика Марий Эл', 'code' => 'MariElRepublic'],
            ['title' => 'Республика Мордовия', 'code' => 'TheRepublicOfMordovia'],
            ['title' => 'Республика Татарстан', 'code' => 'RepublicOfTatarstan'],
            ['title' => 'Самарская область', 'code' => 'SamaraRegion'],
            ['title' => 'Саратовская область', 'code' => 'SaratovRegion'],
            ['title' => 'Удмуртская Республика', 'code' => 'Udmurtrepublic'],
            ['title' => 'Ульяновская область', 'code' => 'UlyanovskRegion'],
            ['title' => 'Чувашская Республика', 'code' => 'ChuvashRepublic'],
            ['title' => 'Архангельская область', 'code' => 'ArhangelskRegion'],
            ['title' => 'Вологодская область', 'code' => 'VologodskayaOblast'],
            ['title' => 'г. Санкт-Петербург', 'code' => 'StPetersburg'],
            ['title' => 'Калининградская область', 'code' => 'KaliningradRegion'],
            ['title' => 'Ленинградская область', 'code' => 'LeningradRegion'],
            ['title' => 'Мурманская область', 'code' => 'MurmanskRegion'],
            ['title' => 'Ненецкий автономный округ', 'code' => 'NenetsAutonomousOkrug'],
            ['title' => 'Новгородская область', 'code' => 'NovgorodRegion'],
            ['title' => 'Псковская область', 'code' => 'PskovRegion'],
            ['title' => 'Республика Карелия', 'code' => 'RepublicOfKarelia'],
            ['title' => 'Республика Коми', 'code' => 'KomiRepublic'],
            ['title' => 'Кабардино-Балкарская Республика', 'code' => 'KabardinoBalkarianRepublic'],
            ['title' => 'Республика Дагестан', 'code' => 'TheRepublicOfDagestan'],
            ['title' => 'Республика Ингушетия', 'code' => 'TheRepublicOfIngushetia'],
            ['title' => 'Республика Карачаево-Черкесия', 'code' => 'RepublicOfKarachayCherkessia'],
            ['title' => 'Республика Северная Осетия-Алания', 'code' => 'RepublicOfNorthOssetiaAlania'],
            ['title' => 'Ставропольский край', 'code' => 'StavropolRegion'],
            ['title' => 'Чеченская Республика', 'code' => 'ChechenRepublic'],
            ['title' => 'Алтайский край', 'code' => 'AltaiRegion'],
            ['title' => 'Забайкальский край', 'code' => 'ZabaykalskyKrai'],
            ['title' => 'Иркутская область', 'code' => 'IrkutskRegion'],
            ['title' => 'Кемеровская область', 'code' => 'KemerovoRegion'],
            ['title' => 'Красноярский край', 'code' => 'KrasnoyarskRegion'],
            ['title' => 'Новосибирская область', 'code' => 'NovosibirskRegion'],
            ['title' => 'Омская область', 'code' => 'OmskRegion'],
            ['title' => 'Республика Алтай', 'code' => 'AltaiRepublic'],
            ['title' => 'Республика Бурятия', 'code' => 'TheRepublicOfBuryatia'],
            ['title' => 'Республика Тыва', 'code' => 'TyvaRepublic'],
            ['title' => 'Республика Хакасия', 'code' => 'TheRepublicOfKhakassia'],
            ['title' => 'Томская область', 'code' => 'TomskRegion'],
            ['title' => 'Курганская область', 'code' => 'KurganRegion'],
            ['title' => 'Свердловская область', 'code' => 'SverdlovskRegion'],
            ['title' => 'Тюменская область', 'code' => 'TyumenRegion'],
            ['title' => 'Ханты-Мансийский автономный округ - Югра', 'code' => 'KhantyMansiAutonomousOkrugYugra'],
            ['title' => 'Челябинская область', 'code' => 'ChelyabinskRegion'],
            ['title' => 'Ямало-Ненецкий автономный округ', 'code' => 'YamaloNenetsAutonomousOkrug'],
            ['title' => 'Белгородская область', 'code' => 'BelgorodRegion'],
            ['title' => 'Брянская область', 'code' => 'BryanskRegion'],
            ['title' => 'Владимирская область', 'code' => 'VladimirRegion'],
            ['title' => 'Воронежская область', 'code' => 'VoronezhRegion'],
            ['title' => 'г. Москва', 'code' => 'MoscowCity'],
            ['title' => 'Ивановская область', 'code' => 'IvanovoRegion'],
            ['title' => 'Калужская область', 'code' => 'KalugaRegion'],
            ['title' => 'Костромская область', 'code' => 'KostromaRegion'],
            ['title' => 'Курская область', 'code' => 'KurskRegion'],
            ['title' => 'Липецкая область', 'code' => 'LipetskRegion'],
            ['title' => 'Московская область', 'code' => 'MoscowRegion'],
            ['title' => 'Орловская область', 'code' => 'OryolRegion'],
            ['title' => 'Рязанская область', 'code' => 'RyazanOblast'],
            ['title' => 'Смоленская область', 'code' => 'SmolenskRegion'],
            ['title' => 'Тамбовская область', 'code' => 'TambovRegion'],
            ['title' => 'Тверская область', 'code' => 'TverRegion'],
            ['title' => 'Тульская область', 'code' => 'TulaRegion'],
            ['title' => 'Ярославская область', 'code' => 'YaroslavlRegion'],
            ['title' => 'Астраханская область', 'code' => 'AstrakhanRegion'],
            ['title' => 'Волгоградская область', 'code' => 'VolgogradRegion'],
            ['title' => 'г.Севастополь', 'code' => 'Sevastopol'],
            ['title' => 'Краснодарский край', 'code' => 'KrasnodarRegion'],
            ['title' => 'Республика Адыгея', 'code' => 'RepublicOfAdygea'],
            ['title' => 'Республика Калмыкия', 'code' => 'RepublicOfKalmykia'],
            ['title' => 'Республика Крым', 'code' => 'RepublicOfCrimea'],
            ['title' => 'Ростовская область', 'code' => 'RostovRegion']

        ];

        foreach($regions as $region){
            Region::create([
               'title'=>$region['title'],
               'code'=>$region['code']
            ]);
        }
    }
}
