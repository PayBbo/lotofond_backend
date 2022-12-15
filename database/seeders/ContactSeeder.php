<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts = [
            ['contact'=>'imedia.penza@yandex.ru', 'tariff_id'=>5],
            ['contact'=>'imedia.penza@yandex.ru', 'tariff_id'=>6],
            ['contact'=>'imedia.penza@yandex.ru', 'tariff_id'=>7],
            ['contact'=>'imedia.penza@yandex.ru', 'tariff_id'=>8],
            ['contact'=>'imedia.penza@yandex.ru', 'tariff_id'=>9],
            ['contact'=>'imedia.penza@yandex.ru', 'tariff_id'=>10],
            ['contact'=>'imedia.penza@yandex.ru', 'tariff_id'=>11],

            ['contact'=>'vicemine@mail.ru', 'tariff_id'=>5],
            ['contact'=>'vicemine@mail.ru', 'tariff_id'=>6],
            ['contact'=>'vicemine@mail.ru', 'tariff_id'=>7],
            ['contact'=>'vicemine@mail.ru', 'tariff_id'=>8],
            ['contact'=>'vicemine@mail.ru', 'tariff_id'=>9],
            ['contact'=>'vicemine@mail.ru', 'tariff_id'=>10],
            ['contact'=>'vicemine@mail.ru', 'tariff_id'=>11],

            ['contact'=>'deighd08@gmail.com', 'tariff_id'=>5],
            ['contact'=>'deighd08@gmail.com', 'tariff_id'=>6],
            ['contact'=>'deighd08@gmail.com', 'tariff_id'=>7],
            ['contact'=>'deighd08@gmail.com', 'tariff_id'=>8],
            ['contact'=>'deighd08@gmail.com', 'tariff_id'=>9],
            ['contact'=>'deighd08@gmail.com', 'tariff_id'=>10],
            ['contact'=>'deighd08@gmail.com', 'tariff_id'=>11],

        ];

        foreach($contacts as $contact){
            Contact::create([
                'contact'=>$contact['contact'],
                'tariff_id'=>$contact['tariff_id']
            ]);
        }
    }
}
