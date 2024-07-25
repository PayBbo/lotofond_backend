<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class OrderResource extends JsonResource
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
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'socials' => $this->for_answer,
            'files' => $this->getFiles(),
            'topic' => $this->topic,
            'question' => $this->question,
            'dateForAnswer' => !is_null($this->answer_date) ? Carbon::parse($this->answer_date)->format('d.m.Y h:i') : null,
            'type' => $this->type,
            'tariffId'=> $this->tariff_id,
            'lotUrl' => URL::to('/lot/' . $this->lot_id),
            'lotId' => $this->lot_id,
//            'status'=>__('trades.statuses.'.$this->status),
            'status'=> $this->status,
            'paymentId' => $this->payment_id . ( !is_null($this->payment_id) ? ($this->payment->status == 'Settled' ? ' - подтвержден': ' - не подтвержден') : ''),
            'createdAt'=> $this->created_at,
            'publishDate'=> $this->created_at->format('d.m.Y H:i'),
            'publishDateIso'=> $this->created_at->format('c'),
            'cadastralNumber' =>  $this->cadastral_number,
            $this->mergeWhen(!is_null($this->lot_id), [
                'lot' => [
                    'photos' => is_null($this->lot_id) ? null : $this->lot->photos,
                    'description' => is_null($this->lot_id) ? null : ($this->contentSettings->isAvailable('descriptionExtracts') ? $this->lot->description : $this->lot->processed_description),
                    'favouritePaths' => is_null($this->lot_id) ? null : $this->lot->getLotFavouritePaths(),
                    'id' => is_null($this->lot_id) ? null : $this->lot->id,
                    'categories' => is_null($this->lot_id) ? [] : $this->lot->categoriesStructure(),
                ]
            ])
        ];
    }
}
