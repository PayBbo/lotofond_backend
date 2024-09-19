<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\Admin\UserCollection;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\TextDataResource;
use App\Http\Services\Parse\SoapWrapperService;
use App\Http\Services\PaymentService;
use App\Models\Payment;
use App\Models\Region;
use App\Models\Tariff;
use App\Models\TextData;
use App\Models\User;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class FedresursController extends Controller
{

    public function getTradeMessages(Request $request)
    {
        try {
            $startFrom = $request->start_from ?: Carbon::now()->setTimezone('Europe/Moscow')->subMinutes(15)->format('Y-m-d\TH:i:s');
            $endTo = $request->end_from ?: Carbon::now()->setTimezone('Europe/Moscow')->format('Y-m-d\TH:i:s');
            $soapWrapper = new SoapWrapper();
            $service = new SoapWrapperService($soapWrapper);
            return $service->getTradeMessages($startFrom, $endTo);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getMessageIds(Request $request)
    {
        try {
            $startFrom = $request->start_from ?: Carbon::now()->setTimezone('Europe/Moscow')->subMinutes(15)->format('Y-m-d\TH:i:s');
            $endTo = $request->end_to ?: Carbon::now()->setTimezone('Europe/Moscow')->format('Y-m-d\TH:i:s');
            $soapWrapper = new SoapWrapper();
            $service = new SoapWrapperService($soapWrapper);
            return $service->getMessageIds($startFrom, $endTo);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getMessageContent($id)
    {
        try {
            $soapWrapper = new SoapWrapper();
            $service = new SoapWrapperService($soapWrapper);
            return $service->getMessageContent($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getTradeMessageContent($id)
    {
        try {
            $soapWrapper = new SoapWrapper();
            $service = new SoapWrapperService($soapWrapper);
            return $service->getTradeMessageContent($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getTradeMessagesByTrade()
    {
        try {
            $id = request()->get('id');
            $tradePlaceInn = request()->get('trade_place_inn');
            $startFrom = request()->get('start_from');
            $endTo = request()->get('end_to', null);
            $soapWrapper = new SoapWrapper();
            $service = new SoapWrapperService($soapWrapper);
            return $service->getTradeMessagesByTrade($id, $tradePlaceInn, $startFrom, $endTo);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}

