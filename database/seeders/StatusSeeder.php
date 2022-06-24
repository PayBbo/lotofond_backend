<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Type;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['code' => 'BiddingInvitation', 'value' => 'Сообщение о продаже'],
            ['code' => 'BiddingDeclaration', 'value' => 'Объявлены торги'],
            ['code' => 'ApplicationSessionStart', 'value' => 'Начат прием заявок'],
            ['code' => 'ApplicationSessionEnd', 'value' => 'Приём заявок закончен'],
            ['code' => 'BiddingStart', 'value' => 'Начаты торги'],
            ['code' => 'BiddingEnd', 'value' => 'Торги завершены'],
            ['code' => 'BiddingCancel', 'value' => 'Отмена торгов'],
            ['code' => 'Annulment', 'value' => 'Аннулирование'],
            ['title' => 'not_been', 'code' => 'BiddingFail', 'value' => 'Торги не состоялись'],
            ['code' => 'BiddingPause', 'value' => 'Торги приостановлены'],
            ['code' => 'BiddingResume', 'value' => 'Торги возобновлены'],

        ];
        foreach ($types as $type) {
            Status::create([
                'code' => $type['code'],
                'value' => $type['value']
            ]);
        }

        $bidder_types = [
            'arbitrManager',
            'organizer',
            'debtor',
            'participant'
        ];
        foreach ($bidder_types as $bidder_type) {
            Type::create([
                'title' => $bidder_type
            ]);
        }
    }
}
