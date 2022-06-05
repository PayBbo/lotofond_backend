<?php

namespace Database\Seeders;

use App\Models\DebtorCategory;
use Illuminate\Database\Seeder;

class DebtorCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['title'=>'Градообразующая организация', 'code'=>'CityOrganization'],
            ['title'=>'Застройщик', 'code'=>'DevelopmentOrganization'],
            ['title'=> 'Иная финансовая организация', 'code'=>'OtherOrganization'],
            ['title'=> 'Индивидуальный предприниматель', 'code'=>'EnterpreneurPerson'],
            ['title'=>'Кредитная организация', 'code'=>'CreditOrganization'],
            ['title'=> 'Крестьянское (фермерское) хозяйство', 'code'=>'FarmerPerson'],
            ['title'=>'Ликвидируемый должник', 'code'=>'DissolvedBankruptOrganization'],
            ['title'=>'Обычная организация', 'code'=>'SimpleOrganization'],
            ['title'=> 'Отсутствующий должник', 'code'=>'AbsentBankrupt'],
            ['title'=> 'Сельскохозяйственная организация', 'code'=>'AgricultureOrganization'],
            ['title'=>'Стратегическое предприятие и организация', 'code'=>'StrategicOrganization'],
            ['title'=> 'Субъект естественных монополий', 'code'=>'MonopolyOrganization'],
            ['title'=> 'Физическое лицо', 'code'=>'SimplePerson'],
            ['title'=>'Негосударственный пенсионный фонд', 'code'=>'PrivatePensionFund'],
            ['title'=>'Страховая организация', 'code'=>'InsuranceOrganization'],

        ];
        foreach($categories as $category){
            DebtorCategory::create([
                'code'=>$category['code'],
                'title'=>$category['title']
            ]);
        }
    }
}
