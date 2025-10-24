<?php

namespace App\Http\Resources;

use App\Models\LotFile;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $lotFiles = LotFile::where('auction_id', $this->auction_id)->orWhere('lot_id', $this->id)->get();
        return [
            'files' => $lotFiles->where('type', 'file')->pluck('url')->toArray(),
            'auctionFiles' => $lotFiles->where('auction_id', $this->auction_id)->where('lot_id', null)->pluck('url')->toArray(),
            'userFiles' => auth()->check() ? $lotFiles->where('user_id', auth()->id())->where('type', 'file')->toArray() : [],
            'images' => $lotFiles->filter(function ($image) {
                return ($image->type === 'image' || $image->type === 'video') && ($image->user_id === null || $image->user_id === auth()->guard('api')->id());
            })
                ->map(function ($image) {
                    return [
                        'filetype' => $image->type,
                        'type' => $image->user_id === null ? 'system' : 'user',
                        'main' => $image->url[0],
                        'preview' => $image->url[1],
                        'id' => $image->id
                    ];
                })
                ->toArray(),
            'allUserFiles' => auth()->check() ? $lotFiles->where('user_id', auth()->id())->where('type', 'file')->toArray() : [],
        ];
    }
}
