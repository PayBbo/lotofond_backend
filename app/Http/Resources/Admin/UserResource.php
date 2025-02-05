<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'surname'=>$this->surname,
            'middleName'=>$this->middle_name,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'isAdmin'=> $this->hasRole('admin'),
            'authId'=>auth()->id(),
            'registrationDate'=> is_null($this->email_verified_at) ? 'Не указано' : $this->email_verified_at->format('d.m.Y H:i'),
            'roles'=> $this->roles->pluck('name'),
            'tariff'=> $this->tariff ? $this->tariff->tariff->id : null,
            'botTariff'=> $this->botTariff ? $this->botTariff->tariff->id : null,
            'tgId'=> $this->tg_id ?: null,
            'tgConnectedAt'=> $this->tg_connected_at ?: null,
            'diffInDays' =>  $this->finished_at ? Carbon::now()->diffInDays($this->finished_at) : null,
            'finishedAt' => $this->finished_at,
            'region'=>!is_null($this->region_id) ? $this->region->title : null
        ];
    }
}
