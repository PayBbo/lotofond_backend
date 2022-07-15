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
            $this->mergeWhen(self::$conditions['addTradeNumber'], [
                'tradeNumber' => $this->auction->trade_id,
            ]),
            $this->mergeWhen(self::$conditions['addEfrsbLink'], [
                'efrsbLink' => 'https://fedresurs.ru/bidding/' . $this->auction->guid,
            ]),
            $this->mergeWhen(self::$conditions['addDescription'], [
                'description' => stripslashes(preg_replace('/[\x00-\x1F\x7F]/u', ' ', $this->description)),
            ]),
            $this->mergeWhen(self::$conditions['addCurrentPrice'], [
                'currentPrice' => (float)$this->current_price,
            ]),
            $this->mergeWhen(self::$conditions['addAuctionType'], [
                'auctionType' => $this->auction->auctionType->title,
            ]),
            $this->mergeWhen(self::$conditions['addDebtor'], [
                'debtor' => $this->auction->debtor->getNameForExport(),
            ]),
            $this->mergeWhen(self::$conditions['addArbitrationManager'], [
                'arbitrationManager' => $this->auction->arbitrationManager->getNameForExport(),
            ]),
            $this->mergeWhen(self::$conditions['addApplicationStart'], [
                'applicationStart' => is_null($this->auction->application_start_date) ? '-' :  $this->auction->application_start_date->format('d.m.Y h:i'),
            ]),
            $this->mergeWhen(self::$conditions['addApplicationEnd'], [
                'applicationEnd' => is_null($this->auction->application_end_date) ? '-' :  $this->auction->application_end_date->format('d.m.Y h:i'),
            ]),
            $this->mergeWhen(self::$conditions['addWinner'], [
                'winner' => 'Победитель торгов',
            ]),
            $this->mergeWhen(self::$conditions['addLotNumber'], [
                'lotNumber' => $this->number,
            ]),
            $this->mergeWhen(self::$conditions['addTradePlace'], [
                'tradePlace' => $this->auction->tradePlace->name . ' ' . $this->auction->tradePlace->site,
            ]),
            $this->mergeWhen(self::$conditions['addStartPrice'], [
                'startPrice' => (float)$this->start_price,
            ]),
            $this->mergeWhen(self::$conditions['addMinPrice'], [
                'minPrice' => (float)$this->min_price,
            ]),
            $this->mergeWhen(self::$conditions['addRegion'], [
                'region' => $this->auction->debtor->region ? __('regions.' . $this->auction->debtor->region->code) : null,
            ]),
            $this->mergeWhen(self::$conditions['addOrganizer'], [
                'organizer' => $this->auction->companyTradeOrganizer->getNameForExport(),
            ]),
            $this->mergeWhen(self::$conditions['addEventStart'], [
                'eventStart' => is_null($this->auction->event_start_date) ? '-' :  $this->auction->event_start_date->format('d.m.Y h:i'),
            ]),
            $this->mergeWhen(self::$conditions['addEventEnd'], [
                'eventEnd' => is_null($this->auction->event_end_date) ? '-' : $this->auction->event_end_date->format('d.m.Y h:i'),
            ]),
            $this->mergeWhen(self::$conditions['addNote'], [
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
