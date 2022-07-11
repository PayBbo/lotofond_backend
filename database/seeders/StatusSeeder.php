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
            ['code' => 'biddingDeclared', 'value' => 'Объявлены торги'],
            ['code' => 'applicationSessionStarted', 'value' => 'Начат прием заявок'],
            ['code' => 'applicationSessionEnd', 'value' => 'Приём заявок закончен'],
            ['code' => 'biddingInProcess', 'value' => 'Идут торги'],
            ['code' => 'finished', 'value' => 'Торги завершены'],
            ['code' => 'biddingCanceled', 'value' => 'Отмена торгов'],
            ['code' => 'annul', 'value' => 'Аннулирование'],
            ['code' => 'biddingFail', 'value' => 'Торги не состоялись'],
            ['code' => 'biddingPaused', 'value' => 'Торги приостановлены']

        ];
        foreach ($types as $type) {
            Status::create([
                'code' => $type['code'],
                'value' => $type['value']
            ]);
        }

        $bidder_types = [
            'arbitrationManager',
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
