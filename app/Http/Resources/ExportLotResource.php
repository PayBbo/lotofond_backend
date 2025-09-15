<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExportLotResource extends JsonResource
{
    private static $conditions;


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            $this->mergeWhen(self::$conditions['addTradeNumber'] != false, [
                'tradeNumber' => $this->auction->trade_id,
            ]),
            $this->mergeWhen(isset(self::$conditions['addEfrsbLink']) && self::$conditions['addEfrsbLink'] != false, [
                'efrsbLink' => 'https://fedresurs.ru/bidding/' . $this->auction->guid,
            ]),
            $this->mergeWhen(self::$conditions['addSourceLink'] != false, [
                'sourceLink' => $this->auction->source_id == 1 ? 'https://fedresurs.ru/bidding/' . $this->auction->guid
                    : 'https://torgi.gov.ru/new/public/lots/lot/'. $this->guid,
            ]),
            $this->mergeWhen(self::$conditions['addDescription'] != false, [
                'description' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->description)),
            ]),
            $this->mergeWhen(self::$conditions['addCurrentPrice'] != false, [
                'currentPrice' => (float)$this->start_price,
            ]),
            $this->mergeWhen(self::$conditions['addAuctionType'] != false, [
                'auctionType' => __('trades.type.'.$this->auction->auctionType->title),
            ]),
            $this->mergeWhen(self::$conditions['addDebtor'] != false, [
                'debtor' => $this->auction->debtor ? ($this->auction->debtor->getNameForExport() ?: '') : '',
            ]),
            $this->mergeWhen(self::$conditions['addArbitrationManager'] != false, [
                'arbitrationManager' => $this->auction->arbitrationManager ? ($this->auction->arbitrationManager->getNameForExport() ?: '') : '',
            ]),
            $this->mergeWhen(self::$conditions['addApplicationStart'] != false, [
                'applicationStart' => is_null($this->auction->application_start_date) ? '-' :  $this->auction->application_start_date->format('d.m.Y h:i'),
            ]),
            $this->mergeWhen(self::$conditions['addApplicationEnd'] != false, [
                'applicationEnd' => is_null($this->auction->application_end_date) ? '-' :  $this->auction->application_end_date->format('d.m.Y h:i'),
            ]),
            $this->mergeWhen(isset(self::$conditions['addWinner']) && self::$conditions['addWinner'] != false, [
                'winner' => 'Победитель торгов',
            ]),
            $this->mergeWhen(self::$conditions['addLotNumber'] != false, [
                'lotNumber' => $this->number,
            ]),
            $this->mergeWhen(self::$conditions['addTradePlace'] != false, [
                'tradePlace' => $this->auction->tradePlace->name . ' ' . $this->auction->tradePlace->site,
            ]),
            $this->mergeWhen(self::$conditions['addStartPrice'] != false, [
                'startPrice' => (float)$this->start_price,
            ]),
            $this->mergeWhen(self::$conditions['addMinPrice'] != false, [
                'minPrice' => (float)$this->min_price,
            ]),
            $this->mergeWhen(self::$conditions['addRegion'] != false, [
                'region' => $this->auction->debtor && $this->auction->debtor->region ? __('regions.' . $this->auction->debtor->region->code) : null,
            ]),
            $this->mergeWhen(self::$conditions['addOrganizer'] != false, [
                'organizer' => $this->auction->companyTradeOrganizer ? ($this->auction->companyTradeOrganizer->getNameForExport() ?: '') : '',
            ]),
            $this->mergeWhen(self::$conditions['addEventStart'] != false, [
                'eventStart' => is_null($this->auction->event_start_date) ? '-' :  $this->auction->event_start_date->format('d.m.Y h:i'),
            ]),
            $this->mergeWhen(self::$conditions['addEventEnd'] != false, [
                'eventEnd' => is_null($this->auction->event_end_date) ? '-' : $this->auction->event_end_date->format('d.m.Y h:i'),
            ]),
            $this->mergeWhen(isset(self::$conditions['addNote']) && self::$conditions['addNote'] != false, [
                'note' => 'Заметка по лоту'
            ])
        ];
    }

    public static function customCollection($resource, $conditions): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        self::$conditions = $conditions;
        return parent::collection($resource);
    }
}
