<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Requests\CheckPaymentRequest;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TariffResource;
use App\Http\Services\PaymentService;
use App\Models\Payment;
use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(PaymentRequest $request)
    {
        $tariff = Tariff::find($request->tariffId);
        $payment = new Payment();
        $payment->user_id = auth()->id();
        $payment->sum = $tariff->price;
        $payment->tariff_id = $tariff->id;
        $payment->save();
        $paymentService = new PaymentService();
        $paymentRequest = $paymentService->paymentRequest($payment->id, $tariff);
        if (array_key_exists('paymentId', $paymentRequest)) {
            $paymentId = $paymentRequest['paymentId'];
            $payment->payment_id = $paymentId;
            $payment->token = hash('sha256', $payment->id);
            $payment->save();
            return response([
                'redirectUrl' => $paymentRequest['url']
            ], 200);

        }
        throw new BaseException('ERR_CREATE_PAYMENT_FAILED', 403, $paymentRequest);

    }

    public function paymentNotification(Request $request)
    {
        $order_id = $request->id;
        $payment = Payment::where('payment_id', $order_id)->first();
        if ($payment) {
            $paymentService = new PaymentService();
            $paymentStatus = $paymentService->getPaymentStatus($order_id);
            if ($paymentStatus['testMode'] == config('paymaster.test_mode') && $paymentStatus['merchantId'] == config('paymaster.merchant_id')) {
                if (!$payment->is_confirmed && $payment->status != 'Settled' && $paymentStatus['status'] == 'Settled') {
                    if (!is_null($payment->tariff_id)) {
                        if(!is_null($payment->tariff->period)) {
                            $payment->finished_at = Carbon::now()->setTimezone('Europe/Moscow')->addDays($payment->tariff->period);
                            $paymentService->checkPreviousActiveTariff($payment->user_id, $payment->tariff->period);
                        }
                    }
                    $payment->status = $paymentStatus['status'];
                    $payment->is_confirmed = true;
                    $payment->save();
                } else {
                    logger('FailPaymentNot:');
                    logger($paymentStatus);
                    if($paymentStatus['status'] != $payment->status) {
                        $payment->status = $paymentStatus['status'];
                        if($paymentStatus['status'] != 'Settled') {
                            $payment->is_confirmed = false;
                        }
                        $payment->save();
                    }
                }
                return response(null, 200);
            }

        }
        throw new BaseException('ERR_VALIDATE_PAYMENT_FAILED', 422, __('validation.payment_error'));
    }

    public function checkStatus(CheckPaymentRequest $request){
        $paymentToken = $request->paymentId;
        if(strpos($request->paymentId, "?")) {
            $paymentToken = substr($request->paymentId, 0, strpos($request->paymentId, "?"));
        }
        $payment = Payment::where('token', $paymentToken)->first();
        if($payment && $payment->is_confirmed && $payment->status == 'Settled'){
            return response(['status'=> $payment->status], 200);
        }
        if ($payment) {
            $paymentService = new PaymentService();
            $paymentStatus = $paymentService->getPaymentStatus($payment->payment_id);
            if ($paymentStatus['testMode'] == config('paymaster.test_mode') && $paymentStatus['merchantId'] == config('paymaster.merchant_id')) {
                if ($paymentStatus['status'] == 'Settled') {
                    if (!is_null($payment->tariff_id)) {
                        if(!is_null($payment->tariff->period)) {
                            $payment->finished_at = Carbon::now()->setTimezone('Europe/Moscow')->addDays($payment->tariff->period);
                            $paymentService->checkPreviousActiveTariff($payment->user_id, $payment->tariff->period);
                        }
                    }
                    $payment->status = $paymentStatus['status'];
                    $payment->is_confirmed = true;
                    $payment->save();
                } else {
                    if($paymentStatus['status'] != $payment->status) {
                        $payment->status = $paymentStatus['status'];
                        $payment->is_confirmed = true;
                        $payment->save();
                    }
                }
                return response(['status'=> $paymentStatus['status']], 200);
            }

        }
        throw new BaseException('ERR_VALIDATE_PAYMENT_FAILED', 422, __('validation.payment_error'));

    }

    public function getTariffs()
    {
        $tariffs = Tariff::where('type', 'tariff')->where('active', true)->get();
        return response(TariffResource::collection($tariffs), 200);
    }

    public function getServices(Request $request){
        $servicesTypes = $request->serviceTypes ?? [];
        $services = Tariff::when(count($servicesTypes)>0, function ($query) use ($servicesTypes){
            $query->whereIn('code', $servicesTypes);
        })->where('type', 'service')->where('active', true)->get();
        return response(ServiceResource::collection($services), 200);
    }


}
