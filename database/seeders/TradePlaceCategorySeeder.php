<?php

namespace Database\Seeders;

use App\Models\TradePlaceCategory;
use Illuminate\Database\Seeder;

class TradePlaceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['title' => ['ru' => 'Банкротство', 'en' => 'Bankruptcy', 'zh_CN' => '破产']],
            ['title' => ['ru' => 'Torgi.gov.ru', 'en' => 'Torgi.gov.ru', 'zh_CN' => 'Torgi.gov.ru']],
            ['title' => ['ru' => 'Залоговое', 'en' => 'Collateral', 'zh_CN' => '抵押品']],
            ['title' => ['ru' => 'Неликвид', 'en' => 'Unmarketable', 'zh_CN' => '不可销售']],
            ['title' => ['ru' => 'Коммерческие', 'en' => 'Commercial', 'zh_CN' => '商业广告']],
        ];

        foreach($categories as $category){
            TradePlaceCategory::create([
               'title'=>$category['title']
            ]);
        }
    }
}
