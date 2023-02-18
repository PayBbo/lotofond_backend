<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
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
            'message'=>$this->message,
            'filesCount'=>$this->files->count(),
            'isModerated'=>$this->is_moderated,
            'date'=>Carbon::parse($this->created_at)->format('d.m.Y'),
            'lotId'=>$this->lot_id,
            $this->mergeWhen(\Request::route()->getName() == 'edit.addition', [
                'files'=>$this->files()->where('type', 'file')->select('id', 'url')->get(),
                'images'=>$this->files()->where('type', 'image')->select('id', 'url')->get()
            ])

        ];
    }
}
