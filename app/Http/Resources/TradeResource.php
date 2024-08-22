<?php

namespace App\Http\Resources;

use App\Http\Services\ContentSettingsService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class TradeResource extends JsonResource
{
    protected $contentSettings;

    public function content($settings)
    {
        $this->contentSettings = $settings;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $trade = [
            'id' => $this->id,
            'externalId' => $this->contentSettings->isAvailable( 'externalId') ? $this->trade_id : null,
            'lotCount' => $this->contentSettings->isAvailable( 'lotCount') ? $this->lots_count : null,
            'type' => $this->contentSettings->isAvailable( 'type') ? $this->auctionType->title : null,
            'publishDate'=> $this->contentSettings->isAvailable( 'publishDate') ?  $this->publish_date : null,
            'eventTime' => $this->contentSettings->isAvailable( 'eventTime') ? [
                'start' => $this->event_start_date,
                'end' => $this->event_end_date,
                'result' => $this->result_date,
            ] : null,
            'applicationTime' => $this->contentSettings->isAvailable( 'applicationTime') ? [
                'start' => $this->application_start_date,
                'end' => $this->application_end_date,
            ] : null,
        ];
        if($this->isLotInfo === true){
            /*   $trade['publishDateSmi'] =  $this->date_publish_efir;
           $trade['publishDateEfir'] = $this->date_publish_smi;*/
            $trade['priceOfferForm'] =  $this->contentSettings->isAvailable( 'priceOfferForm') ? $this->price_form : null;
            $trade['organizer'] = $this->contentSettings->isAvailable( 'organizer') ? new BidderResource($this->companyTradeOrganizer) : null;
            $trade['arbitrationManager'] = $this->contentSettings->isAvailable( 'arbitrationManager') ? new BidderResource($this->arbitrationManager) : null;
            $trade['debtor'] =  $this->contentSettings->isAvailable( 'debtor') ? new BidderResource($this->debtor) : null;
           // $trade['lotCount'] = $this->isAvailable( 'lotCount') ? $this->lots->count() : null;
            $trade['tradePlace'] = $this->contentSettings->isAvailable( 'tradePlace') && $this->tradePlace ? [
                'name' => isset($this->tradePlace->name) ? $this->tradePlace->name : '',
                'site' => str_starts_with($this->tradePlace->site, 'http') ? $this->tradePlace->site : 'http://'.$this->tradePlace->site
            ] : null;
        }
        if(Route::getCurrentRoute()->getName() === 'bidders-trades'){
            $trade['organizer'] = $this->contentSettings->isAvailable( 'organizer') ? new BidderResource($this->companyTradeOrganizer) : null;
            $trade['tradePlace'] =  $this->contentSettings->isAvailable( 'tradePlace')  && $this->tradePlace ? [
                'name' => isset($this->tradePlace->name) ? $this->tradePlace->name : '',
                'site' => str_starts_with($this->tradePlace->site, 'http') ? $this->tradePlace->site : 'http://'.$this->tradePlace->site
            ] : null;
        }

        return $trade;
    }
}
