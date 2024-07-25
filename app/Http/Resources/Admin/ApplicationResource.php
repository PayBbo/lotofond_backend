<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
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
            'status' => $this->status,
            'cadastral_number' => $this->cadastral_number,
            'paymentId' => $this->payment_id . ( !is_null($this->payment_id) ? ($this->payment->status == 'Settled' ? ' - подтвержден': ' - не подтвержден') : ''),
            'publishDate'=> $this->created_at->format('d.m.Y H:i')
        ];
    }
}
