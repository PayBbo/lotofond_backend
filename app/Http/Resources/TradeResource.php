<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class TradeResource extends JsonResource
{
    protected $contentRules;

    public function contentRules($contentRules=null)
    {
        $this->contentRules = $contentRules;
        return $this;
    }

    public function isAvailable($code){
        $authCheck = auth()->guard('api')->check();
        if($authCheck){
            return $this->contentRules[$code];
        }
        return true;
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
            'externalId' => $this->isAvailable( 'externalId') ? $this->trade_id : null,
            'lotCount' => $this->isAvailable( 'lotCount') ? $this->lots_count : null,
            'type' => $this->isAvailable( 'type') ? $this->auctionType->title : null,
            'publishDate'=> $this->isAvailable( 'publishDate') ?  $this->publish_date : null,
            'eventTime' => $this->isAvailable( 'eventTime') ? [
                'start' => $this->event_start_date,
                'end' => $this->event_end_date,
                'result' => $this->result_date,
            ] : null,
            'applicationTime' => $this->isAvailable( 'applicationTime') ? [
                'start' => $this->application_start_date,
                'end' => $this->application_end_date,
            ] : null,
        ];
        if($this->isLotInfo === true){
            /*   $trade['publishDateSmi'] =  $this->date_publish_efir;
           $trade['publishDateEfir'] = $this->date_publish_smi;*/
            $trade['priceOfferForm'] =  $this->isAvailable( 'priceOfferForm') ? $this->price_form : null;
            $trade['organizer'] = $this->isAvailable( 'organizer') ? new BidderResource($this->companyTradeOrganizer) : null;
            $trade['arbitrationManager'] = $this->isAvailable( 'arbitrationManager') ? new BidderResource($this->arbitrationManager) : null;
            $trade['debtor'] =  $this->isAvailable( 'debtor') ? new BidderResource($this->debtor) : null;
            $trade['tradePlace'] =  $this->isAvailable( 'tradePlace') ? [
                'name' => $this->tradePlace->name,
                'site' => str_starts_with($this->tradePlace->site, 'http') ? $this->tradePlace->site : 'http://'.$this->tradePlace->site
            ] : null;
        }
        if(Route::getCurrentRoute()->getName() === 'bidders-trades'){
            $trade['organizer'] = $this->isAvailable( 'organizer') ? new BidderResource($this->companyTradeOrganizer) : null;
            $trade['tradePlace'] =  $this->isAvailable( 'tradePlace') ? [
                'name' => $this->tradePlace->name,
                'site' => str_starts_with($this->tradePlace->site, 'http') ? $this->tradePlace->site : 'http://'.$this->tradePlace->site
            ] : null;
        }

        return $trade;
    }
}
