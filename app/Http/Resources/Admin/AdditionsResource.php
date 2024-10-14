<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AdditionsResource extends JsonResource
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
            'initial_message'=>$this->initial_message,
            'message'=>$this->message,
            'filesCount'=> $this->files_count ?: $this->files->count(),
            'isModerated'=>$this->is_moderated,
            'rating'=>$this->rating(),
            'date'=>Carbon::parse($this->created_at)->format('d.m.Y'),
            'lotId'=>$this->lot_id,
            'tradeId'=>$this->trade_id,
            $this->mergeWhen(\Request::route()->getName() == 'edit.addition', [
                'files'=>$this->files()->where('type', 'file')->where('additional_lot_info_id' , $this->id)
                    ->select('id', 'url', 'url as name')
                    ->get(),
                'images'=>$this->files()->where('type', 'image')->where('additional_lot_info_id' , $this->id)
                    ->select('id', 'url', 'url as name')
                    ->get()
            ])

        ];
    }
}
