<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Requests\EstimateBidderRequest;
use App\Http\Resources\BidderCollection;
use App\Http\Resources\LotCollection;
use App\Http\Resources\RatingResource;
use App\Http\Resources\ReestrBidderResource;
use App\Http\Resources\ReestrDebtorMessageCollection;
use App\Http\Resources\TradePlaceCollection;
use App\Http\Resources\TradePlaceResource;
use App\Models\Bidder;
use App\Models\BidderEstimate;
use App\Models\Lot;
use App\Models\RegistryNotification;
use App\Models\TradePlace;
use Illuminate\Http\Request;


class BidderController extends Controller
{
    public function getTradesByBidder(Request $request)
    {
        $active_statuses = [1, 2];
        $bidderType = $request->bidderType;
        if ($request->bidderType == 'organizer') {
            $bidderType = 'companyTradeOrganizer';
        }
        $bidderId = $request->bidderId;
        $exceptionLots = [];
        if ($request->has('exceptionLotId')) {
            $exceptionLots[] = $request->exceptionLotId;
        }
        if ($request->type == 'active') {
            $lots = Lot::whereNotIn('id', $exceptionLots)->whereIn('status_id', $active_statuses)->whereHas('auction.' . $bidderType,
                function ($q) use ($bidderId) {
                    $q->where('id', $bidderId);
                })->paginate(20);
        } else {
            $lots = Lot::whereNotIn('id', $exceptionLots)->whereNotIn('status_id', $active_statuses)->whereHas('auction.' . $bidderType,
                function ($q) use ($bidderId) {
                    $q->where('id', $bidderId);
                })->paginate(20);
        }
        return response(new LotCollection($lots), 200);
    }

    public function getBidder($bidderId, $type)
    {
        $bidder = Bidder::where('id', $bidderId)->first();
        if (!$bidder) {
            throw new BaseException("ERR_FIND_BIDDER_FAILED", 404, "Bidder with id= " . $bidderId . ' does not exist');
        }
        $bidder->role = $type;
        return response(new ReestrBidderResource($bidder), 200);
    }

    public function getBidders($type, Request $request)
    {
        $searchString = $request->searchString;
        $type = substr_replace($type, "", -1);
        $perPage = 20;
        if(isset($request->perPage) && strlen($request->perPage) > 0){
            $perPage = $request->perPage;
        }
        $bidders = Bidder::customSortBy($request)
            ->whereHas('types', function ($query) use ($type) {
                $query->where('title', $type);
            })
            ->when(isset($searchString) && strlen($searchString) > 0, function ($query) use ($searchString) {
                $query->where('name', 'LIKE', '%' . $searchString . '%')
                    ->orWhere('short_name', 'LIKE', '%' . $searchString . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $searchString . '%')
                    ->orWhere('middle_name', 'LIKE', '%' . $searchString . '%')
                    ->orWhere('inn', 'LIKE', '%' . $searchString . '%');
            })
            ->paginate($perPage);
        return response(new BidderCollection($bidders), 200);
    }

    public function getTradePlace($tradePlaceId)
    {
        $tradePlace = TradePlace::where('id', $tradePlaceId)->first();
        if (!$tradePlace) {
            throw new BaseException("ERR_FIND_TRADE_PLACE_FAILED", 404, "TradePlace with id= " . $tradePlaceId . ' does not exist');
        }
        $tradePlace->isReestr = true;
        return response(new TradePlaceResource($tradePlace), 200);
    }

    public function getTradePlaces(Request $request)
    {
        $searchString = $request->searchString;
        $perPage = 20;
        if(isset($request->perPage) && strlen($request->perPage) > 0){
            $perPage = $request->perPage;
        }
        $sortType = 'id';
        $sortDirection = 'asc';
        if(isset($request->sort) && count($request->sort) > 0){
          if(isset($request->sort->type) && strlen($request->sort->type)>0){
              $sortType = $request->sort->type;
          }
            if(isset($request->sort->direction) && strlen($request->sort->direction)>0){
                $sortDirection = $request->sort->direction;
            }
        }
        $tradePlaces = TradePlace::when(isset($searchString) && strlen($searchString) > 0, function ($query) use ($searchString) {
                $query->where('name', 'LIKE', '%' . $searchString . '%')
                    ->orWhere('site', 'LIKE', '%' . $searchString . '%');
            })
            ->orderBy($sortType, $sortDirection)
            ->paginate($perPage);
        return response(new TradePlaceCollection($tradePlaces), 200);
    }

    public function estimateBidder(EstimateBidderRequest $request)
    {
        $estimate = BidderEstimate::where(['user_id' => auth()->id(), 'bidder_id' => $request->bidderId, 'type' => $request->type])->first();
        if (!$estimate) {
            $estimate = new BidderEstimate();
        }
        $estimate->estimate = $request->estimate;
        $estimate->comment = $request->comment;
        $estimate->user_id = auth()->id();
        $estimate->bidder_id = $request->bidderId;
        $estimate->type = $request->type;
        $estimate->save();
        $bidder = Bidder::find($request->bidderId);
        $bidder->role = $request->type;

        return response(new RatingResource($bidder), 200);

    }

    public function getDebtorMessages(Request $request)
    {
        $perPage = 20;
        if(isset($request->perPage) && strlen($request->perPage) > 0){
            $perPage = $request->perPage;
        }
        $messages = RegistryNotification::customSortBy($request)->filterBy($request->request)->paginate($perPage);
        return response(new ReestrDebtorMessageCollection($messages), 200);
    }

    public function getDebtorMessageHtml($guid){
        $url='https://old.bankrot.fedresurs.ru/MessageWindow.aspx?ID=' . $guid;
        $curl = curl_init($url);

        $headers = array(
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Cookie: ASP.NET_SessionId=kouo3r2ly4itiioslw50y0sx; bankrotcookie=a9217e5cdbe7965d6a70fcf5e5c1b780',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.5005.134 YaBrowser/22.7.0.1842 Yowser/2.5 Safari/537.36'
        );

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curlinfo = curl_exec($curl);

        curl_close($curl);

        return response()->json(['html'=>$curlinfo], 200);
    }

}
