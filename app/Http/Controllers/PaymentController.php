<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Requests\PaymentRequest;
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
                        $payment->finished_at = Carbon::now()->setTimezone('Europe/Moscow')->addDays($payment->tariff->period);
                    }
                    $payment->status = $paymentStatus['status'];
                    $payment->is_confirmed = true;
                    $payment->save();
                } else {
                    logger('FailPaymentNot:'.$paymentStatus);
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

    public function getTariffs()
    {
        $tariffs = Tariff::all();
        return response(TariffResource::collection($tariffs), 200);
    }


}
