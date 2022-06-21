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
            ['title'=>'beginning', 'code'=>'BiddingInvitation', 'value'=>'Сообщение о продаже'],
            ['title'=>'announced', 'code'=>'BiddingDeclaration', 'value'=>'Объявлены торги'],
            ['title'=>'accept_applications', 'code'=>'ApplicationSessionStart', 'value'=>'Начат прием заявок'],
            ['title'=>'applications_closed', 'code'=>'ApplicationSessionEnd', 'value'=>'Приём заявок закончен'],
            ['title'=>'started', 'code'=>'BiddingStart', 'value'=>'Начаты торги'],
            ['title'=>'completed', 'code'=>'BiddingEnd', 'value'=>'Торги завершены'],
            ['title'=>'canceled', 'code'=>'BiddingCancel', 'value'=>'Отмена торгов'],
            ['title'=>'nullable', 'code'=>'Annulment', 'value'=>'Аннулирование'],
            ['title'=>'not_been', 'code'=>'BiddingFail', 'value'=>'Торги не состоялись'],
            ['title'=>'paused', 'code'=>'BiddingPause', 'value'=>'Торги приостановлены'],
            ['title'=>'resumed', 'code'=>'BiddingResume', 'value'=>'Торги возобновлены'],

        ];
        foreach($types as $type){
            Status::create([
                'title'=>$type['title'],
                'code'=>$type['code'],
                'value'=>$type['value']
            ]);
        }

        $bidder_types = [
            'arbitr_manager',
            'trade_organizer',
            'debtor',
            'participant'
        ];
        foreach ($bidder_types as $bidder_type){
            Type::create([
                'title'=>$bidder_type
            ]);
        }
    }
}
