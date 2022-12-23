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
use App\Http\Services\ContentSettingsService;
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
            $lots = Lot::with(['auction', 'showRegions', 'status', 'lotImages', 'categories', 'lotParams'])
                ->whereNotIn('id', $exceptionLots)->whereIn('status_id', $active_statuses)->whereHas('auction.' . $bidderType,
                    function ($q) use ($bidderId) {
                        $q->where('id', $bidderId);
                    })->paginate(20);
        } else {
            $lots = Lot::with(['auction', 'showRegions', 'status', 'lotImages', 'categories', 'lotParams'])
                ->whereNotIn('id', $exceptionLots)->whereNotIn('status_id', $active_statuses)->whereHas('auction.' . $bidderType,
                    function ($q) use ($bidderId) {
                        $q->where('id', $bidderId);
                    })->paginate(20);
        }
        return response(new LotCollection($lots), 200);
    }

    public function getBidder($bidderId, $type)
    {
        $bidder = Bidder::where('id', $bidderId)->first();
        if (!$bidder || !$bidder->types()->where('title', $type)->exists()) {
            throw new BaseException("ERR_FIND_BIDDER_FAILED", 404, "Bidder with id = " . $bidderId . ' and type = ' . $type . ' does not exist');
        }
        $bidder->role = $type;
        return response(new ReestrBidderResource($bidder), 200);
    }

    public function getBidders($type, Request $request)
    {
        $searchString = $request->searchString;
        $type = substr_replace($type, "", -1);
        $perPage = 20;
        if (isset($request->perPage) && strlen($request->perPage) > 0) {
            $perPage = $request->perPage;
        }
        $bidders = Bidder::customSortBy($request)
            ->with('region')
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
        if (isset($request->perPage) && strlen($request->perPage) > 0) {
            $perPage = $request->perPage;
        }
        $sortType = 'id';
        $sortDirection = 'asc';
        if (isset($request->sort) && count($request->sort) > 0) {
            if (isset($request->sort->type) && strlen($request->sort->type) > 0) {
                $sortType = $request->sort->type;
            }
            if (isset($request->sort->direction) && strlen($request->sort->direction) > 0) {
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
        if (isset($request->perPage) && strlen($request->perPage) > 0) {
            $perPage = $request->perPage;
        }
        $messages = RegistryNotification::customSortBy($request)->filterBy($request->request)->paginate($perPage);
        return response(new ReestrDebtorMessageCollection($messages), 200);
    }

    public function getDebtorMessageHtml(Request $request)
    {
        $url = 'https://old.bankrot.fedresurs.ru/MessageWindow.aspx?ID=' . $request->guid;
        $headers = array(
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.160 YaBrowser/22.5.2.615 Yowser/2.5 Safari/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Cookie: bankrotcookie=' . $request->cookie
        );
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $content = curl_exec($ch);

        curl_close($ch);

        preg_match_all('/(?<=toNumbers\(")(.*?)(?=\")/', $content, $matches, PREG_SET_ORDER, 0);
        if (strlen((string)$request->cookie) > 0 && !is_null($request->cookie) && count($matches) === 0) {
            return response()->json(['html' => $content, 'isSetCookie' => false], 200);
        }
        $arr = array('a' => '4333f122b9293c7ca2ec1b7aa16a256c', 'b' => 'd7c4c5db69e0b79da8fe49cdfb7a0262', 'c' => '0b273cd470b2991d4db2d944d9b25ddf');
        if (count($matches) === 3) {
            $arr = array();
            foreach ($matches as $key => $val) {
                $arr[array('a', 'b', 'c')[$key]] = $val[0];
            }
        }
        return response()->json(['html' => $content, 'arr' => $arr, 'isSetCookie' => true], 200);
    }

    public function getDebtorMessagePage(Request $request)
    {
        $url = 'https://tbankrot.ru/script/ajax.php';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.160 YaBrowser/22.5.2.615 Yowser/2.5 Safari/537.36',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = "key=message&url=https%3A%2F%2Fold.bankrot.fedresurs.ru%2FMessageWindow.aspx%3FID%3D" . $request->guid . "&match_words=Array";

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $responseBody = curl_exec($curl);
        curl_close($curl);
        return response($responseBody);
    }

}
