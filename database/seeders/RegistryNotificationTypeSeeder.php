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
            /*'Сообщения о результатах проведения комитета кредиторов',
            'Сообщения о результатах проведения собрания кредиторов',
            'Сообщения о собрании кредиторов',
            'Уведомления о получении требований кредитора',
            'Уведомления о проведении комитета кредиторов'*/
            ['code' => 'ArbitralDecree', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'Auction', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'Meeting', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'MeetingResult', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'TradeResult', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'Other', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'AppointAdministration', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ChangeAdministration', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'TerminationAdministration', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'BeginExecutoryProcess', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'TransferAssertsForImplementation', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'Annul', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'PropertyInventoryResult', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'PropertyEvaluationReport', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'AssessmentReport', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'SaleContractResult', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'SaleContractResult2', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'Committee', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'CommitteeResult', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'SaleOrderPledgedProperty', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ReceivingCreditorDemand', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'DemandAnnouncement', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'CourtAssertAcceptance', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'FinancialStateInformation', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'BankPayment', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'AssetsReturning', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'CourtAcceptanceStatement', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'DeliberateBankruptcy', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'IntentionCreditOrg', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'LiabilitiesCreditOrg', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'PerformanceCreditOrg', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'BuyingProperty', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'DeclarationPersonDamages', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'DealInvalid', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ActDealInvalid', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ActDealInvalid2', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ActReviewDealInvalid', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ActReviewDealInvalid2', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'DeclarationPersonSubsidiary', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ActPersonSubsidiary', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ActPersonSubsidiary2', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ActReviewPersonSubsidiary', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ActReviewPersonSubsidiary', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'MeetingWorker', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'MeetingWorkerResult', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ViewDraftRestructuringPlan', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ViewExecRestructuringPlan', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'TransferOwnershipRealEstate', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'CancelAuctionTradeResult', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'CancelDeliberateBankruptcy', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ChangeAuction', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ChangeDeliberateBankruptcy', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ReducingSizeShareCapital', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'SelectionPurchaserAssets', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'EstimatesCurrentExpenses', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'OrderAndTimingCalculations', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'InformationAboutBankruptcy', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'EstimatesAndUnsoldAssets', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'RemainingAssetsAndRight', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ImpendingTransferAssets', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'TransferAssets', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'TransferInsurancePortfolio', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'BankOpenAccountDebtor', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ProcedureGrantingIndemnity', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'RightUnsoldAsset', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'TransferResponsibilitiesFund', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ExtensionAdministration', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'MeetingParticipantsBuilding', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'MeetingPartBuildResult', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'PartBuildMonetaryClaim', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'StartSettlement', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ProcessInventoryDebtor', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'Rebuttal', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'CreditorChoiceRightSubsidiary', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'AccessionDeclarationSubsidiary', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'DisqualificationArbitrationManager', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'DisqualificationArbitrationManager2', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ChangeEstimatesCurrentExpenses', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'ReturnOfApplicationOnExtrajudicialBankruptcy', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'StartOfExtrajudicialBankruptcy', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'TerminationOfExtrajudicialBankruptcy', 'title' => '', 'notification_type_group_id' => NULL],
            ['code' => 'CompletionOfExtrajudicialBankruptcy', 'title' => '', 'notification_type_group_id' => NULL],
        ];
        foreach ($types as $type) {
            RegistryNotificationType::create([
                'title' => $type['title'],
                'code'=>$type['code'],
                'notification_type_group_id' => $type['notification_type_group_id']
            ]);
        }
    }
}
