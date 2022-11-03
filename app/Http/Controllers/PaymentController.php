<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Requests\PaymentRequest;
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
        $payment->save();
        $language = $request->header('Content-Language');
        $paymentService = new PaymentService($language);
        $paymentRequest = $paymentService->paymentRequest($payment->id, $tariff->price);
        if (array_key_exists('orderId', $paymentRequest)) {
            $orderId = $paymentRequest['orderId'];
            $payment->payment_id = $orderId;
            $payment->save();
            return response([
                'redirectUrl' => $paymentRequest['formUrl']
            ], 200);

        }
        throw new BaseException('ERR_CREATE_PAYMENT_FAILED', 403, $paymentRequest['errorMessage']);

    }

    public function paymentStatus(Request $request){

        $order_id = $request->orderId;
        $payment = Payment::where('payment_id', $order_id)->first();
        if($payment){
            if(!$payment->is_confirmed){
                $paymentService = new PaymentService('ru');
                $paymentStatus = $paymentService->getOrderStatus($order_id);
                if($paymentStatus['orderStatus'] == 2 ){
                    if(!is_null($payment->tariff_id)) {
                        $payment->finished_at = Carbon::now()->addDays($payment->tariff->period);
                    }
                    $payment->is_confirmed = true;
                    $payment->save();
                    return response(null, 200);
                }
            }
        }
        throw new BaseException('ERR_VALIDATE_PAYMENT_FAILED', 422, __('validation.payment_error'));
    }


}
