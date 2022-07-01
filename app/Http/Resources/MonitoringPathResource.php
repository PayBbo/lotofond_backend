<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MonitoringPathResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow');
        return [
            'pathId'=>$this->id,
            'name'=>$this->title,
            'color'=>$this->color,
            'notificationTime'=>$this->not_time,
            'filters'=>$this->filters,
            'newLotCount'=>$this->lots()->wherePivot('created_at', '>=', $currentDate->subHour())->count()
        ];
    }
}
