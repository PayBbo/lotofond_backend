<?php

namespace App\Http\Controllers;

use App\Http\Resources\BidderCollection;
use App\Models\Bidder;

class BidderController extends Controller
{
    public function getBiddersForFilter($type)
    {
        $bidders = Bidder::has($type.'Auctions')->whereHas('types', function ($query) use ($type) {
            $query->where('title', $type);
        })->paginate(20);
        return response(new BidderCollection($bidders), 200);
    }
}
