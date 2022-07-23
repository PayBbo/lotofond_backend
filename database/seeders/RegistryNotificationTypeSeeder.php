<?php

namespace Database\Seeders;

use App\Models\RegistryNotificationType;
use Illuminate\Database\Seeder;

class RegistryNotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['title' => 'ArbitralDecree',  'notification_group_id' =>  13],
            ['title' => 'Auction',  'notification_group_id' => 5],
            ['title' => 'Meeting',  'notification_group_id' => 2],
            ['title' => 'MeetingResult', 'notification_group_id' => 2],
            ['title' => 'TradeResult', 'notification_group_id' => 5],
            ['title' => 'Other', 'notification_group_id' =>  13],
            ['title' => 'AppointAdministration',  'notification_group_id' => 9],
            ['title' => 'ChangeAdministration', 'notification_group_id' => 9],
            ['title' => 'TerminationAdministration', 'notification_group_id' => 9],
            ['title' => 'BeginExecutoryProcess',  'notification_group_id' => 10],
            ['title' => 'TransferAssertsForImplementation',  'notification_group_id' => 10],
            ['title' => 'Annul',  'notification_group_id' =>  13],
            ['title' => 'PropertyInventoryResult',  'notification_group_id' => 4],
            ['title' => 'PropertyEvaluationReport',  'notification_group_id' =>  13],
            ['title' => 'SaleContractResult',  'notification_group_id' => 5],
            ['title' => 'Committee',  'notification_group_id' => 2],
            ['title' => 'CommitteeResult',  'notification_group_id' => 2],
            ['title' => 'SaleOrderPledgedProperty',  'notification_group_id' => 5],
            ['title' => 'ReceivingCreditorDemand',  'notification_group_id' => 2],
            ['title' => 'DemandAnnouncement',  'notification_group_id' =>  9],
            ['title' => 'CourtAssertAcceptance',  'notification_group_id' => 1],
            ['title' => 'FinancialStateInformation',  'notification_group_id' => 4],
            ['title' => 'BankPayment',  'notification_group_id' => 9],
            ['title' => 'AssetsReturning',  'notification_group_id' => 4],
            ['title' => 'AssessmentReport',  'notification_group_id' => 4],
            ['title' => 'CourtAcceptanceStatement',  'notification_group_id' => 3],
            ['title' => 'DeliberateBankruptcy',  'notification_group_id' =>  12],
            ['title' => 'IntentionCreditOrg',  'notification_group_id' => 9],
            ['title' => 'LiabilitiesCreditOrg',  'notification_group_id' => 9],
            ['title' => 'PerformanceCreditOrg',  'notification_group_id' => 9],
            ['title' => 'BuyingProperty',  'notification_group_id' => 9],
            ['title' => 'DeclarationPersonDamages',  'notification_group_id' => 8],
            ['title' => 'ActPersonDamages',  'notification_group_id' => 8],
            ['title' => 'ActReviewPersonDamages',  'notification_group_id' => 8],
            ['title' => 'DealInvalid',  'notification_group_id' => 7],
            ['title' => 'ActDealInvalid',  'notification_group_id' => 7],
            ['title' => 'ActReviewDealInvalid',  'notification_group_id' => 7],
            ['title' => 'DeclarationPersonSubsidiary',  'notification_group_id' => 8],
            ['title' => 'ActPersonSubsidiary',  'notification_group_id' => 8],
            ['title' => 'ActReviewPersonSubsidiary',  'notification_group_id' => 8],
            ['title' => 'MeetingWorker',  'notification_group_id' => 6],
            ['title' => 'MeetingWorkerResult',  'notification_group_id' => 6],
            ['title' => 'ViewDraftRestructuringPlan',  'notification_group_id' => 11],
            ['title' => 'ViewExecRestructuringPlan',  'notification_group_id' => 11],
            ['title' => 'TransferOwnershipRealEstate',  'notification_group_id' => 3],
            ['title' => 'CancelAuctionTradeResult',  'notification_group_id' => 5],
            ['title' => 'CancelDeliberateBankruptcy',  'notification_group_id' => 12 ],
            ['title' => 'ChangeAuction',  'notification_group_id' => 5],
            ['title' => 'ChangeDeliberateBankruptcy',  'notification_group_id' =>  12],
            ['title' => 'ReducingSizeShareCapital',  'notification_group_id' => 9],
            ['title' => 'SelectionPurchaserAssets',  'notification_group_id' => 9],
            ['title' => 'EstimatesCurrentExpenses',  'notification_group_id' => 9],
            ['title' => 'OrderAndTimingCalculations',  'notification_group_id' => 9],
            ['title' => 'InformationAboutBankruptcy',  'notification_group_id' => 9],
            ['title' => 'EstimatesAndUnsoldAssets',  'notification_group_id' => 9],
            ['title' => 'RemainingAssetsAndRight',  'notification_group_id' => 9],
            ['title' => 'ImpendingTransferAssets',  'notification_group_id' => 9],
            ['title' => 'TransferAssets',  'notification_group_id' => 9],
            ['title' => 'TransferInsurancePortfolio',  'notification_group_id' => 4],
            ['title' => 'BankOpenAccountDebtor',  'notification_group_id' => 4],
            ['title' => 'ProcedureGrantingIndemnity',  'notification_group_id' => 5],
            ['title' => 'RightUnsoldAsset',  'notification_group_id' => 5],
            ['title' => 'TransferResponsibilitiesFund',  'notification_group_id' => 9],
            ['title' => 'ExtensionAdministration',  'notification_group_id' => 9],
            ['title' => 'MeetingParticipantsBuilding',  'notification_group_id' => 3],
            ['title' => 'MeetingPartBuildResult',  'notification_group_id' => 3],
            ['title' => 'PartBuildMonetaryClaim',  'notification_group_id' => 3],
            ['title' => 'StartSettlement',  'notification_group_id' => 9],
            ['title' => 'ProcessInventoryDebtor',  'notification_group_id' => 9],
            ['title' => 'Rebuttal',  'notification_group_id' => 1],
            ['title' => 'CreditorChoiceRightSubsidiary',  'notification_group_id' => 8],
            ['title' => 'AccessionDeclarationSubsidiary',  'notification_group_id' => 8],
            ['title' => 'ChangeEstimatesCurrentExpenses',  'notification_group_id' => 9],
            ['title' => 'ReturnOfApplicationOnExtrajudicialBankruptcy',  'notification_group_id' =>  13],
            ['title' => 'StartOfExtrajudicialBankruptcy',  'notification_group_id' =>  13],
            ['title' => 'TerminationOfExtrajudicialBankruptcy',  'notification_group_id' =>  13],
            ['title' => 'CompletionOfExtrajudicialBankruptcy',  'notification_group_id' =>  13],
        ];
        foreach ($types as $type) {
            RegistryNotificationType::create([
                'title' => $type['title'],
                'notification_group_id' => $type['notification_group_id']
            ]);
        }
    }
}
