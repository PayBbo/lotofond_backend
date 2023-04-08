<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class EgrnStatementResource extends JsonResource
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
            'orderId'=>$this->order_id,
            'file'=>!is_null($this->file) ? URL::to($this->file) : null,
            'applicationId'=>$this->application_id,
            'status'=>$this->status,
            'lastCheckDate'=>Carbon::parse($this->last_check_date)->format('d.m.Y H:i'),
            'cadastralNumber'=> !is_null($this->application_id) ? $this->cadastral_number : null
        ];
    }
}
