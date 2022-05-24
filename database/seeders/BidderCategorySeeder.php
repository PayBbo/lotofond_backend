<?php

namespace Database\Seeders;

use App\Models\BidderCategory;
use Illuminate\Database\Seeder;

class BidderCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Градообразующая организация',
            'Застройщик',
            'Иная финансовая организация',
            'Индивидуальный предприниматель',
            'Кредитная организация',
            'Крестьянское (фермерское) хозяйство',
            'Ликвидируемый должник',
            'Обычная организация',
            'Отсутствующий должник',
            'Сельскохозяйственная организация',
            'Стратегическое предприятие и организация',
            'Субъект естественных монополий',
            'Физическое лицо'
        ];
        foreach($categories as $category){
            BidderCategory::create([
                'title'=>$category
            ]);
        }
    }
}
