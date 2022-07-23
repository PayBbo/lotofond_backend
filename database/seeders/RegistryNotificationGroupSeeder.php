<?php

namespace Database\Seeders;

use App\Models\RegistryNotificationGroup;
use Illuminate\Database\Seeder;

class RegistryNotificationGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'decisionsOfTheArbitrationCourt',
            'meetingsAndCommitteesOfCreditors',
            'messagesForConstructionParticipants',
            'informationAboutAssets',
            'organizationAndImplementationOfTheSaleOfProperty',
            'meetingOfDebtorsEmployees',
            'challengingTheTransaction',
            'responsibilityOfControllingPersons',
            'messagesOnFinancialOrganizations',
            'bailiffsMessages',
            'informationOnTheImplementationOfTheRestructuringPlan',
            'signsOfIntentionalOrFictitiousBankruptcy',
            'otherNotifications',
        ];
        foreach($types as $type){
            RegistryNotificationGroup::create([
                'title'=>$type
            ]);
        }
    }
}
