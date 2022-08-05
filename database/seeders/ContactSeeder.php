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
            ['contact'=>'test@mail.ru', 'type'=>'applications'],
            ['contact'=>'test@mail.ru', 'type'=>'questions']
        ];

        foreach($contacts as $contact){
            Contact::create([
                'contact'=>$contact['contact'],
                'type'=>$contact['type']
            ]);
        }
    }
}
