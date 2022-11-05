<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Models\Payment;
use App\Models\Tariff;
use Carbon\Carbon;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;

class ApplePaymentController extends Controller
{
    public function validateTransaction(Request $request)
    {
        if (!isset($request->receiptData)) {
            throw new BaseException('ERR_VALIDATION_RECEIPT_DATA_FAILED', 422, 'The field receiptData is required');
        }
        $urls = ['https://buy.itunes.apple.com/verifyReceipt', 'https://sandbox.itunes.apple.com/verifyReceipt'];
        $successTransaction = null;
        foreach ($urls as $key=>$url) {
            $response = $this->sendVerifyReceipt($url, $request->receiptData);
            if ($response['status'] == 0) {
                $successTransaction = $response;
                break;
            } else {
                if ($response['status'] != 21007) {
                    throw new BaseException('ERR_VALIDATION_RECEIPT_FAILED', 500, 'Apple server return error with status = ' . $response['status']);
                }else{
                    if($key == 1){
                        throw new BaseException('ERR_VALIDATION_RECEIPT_FAILED', 500, 'Apple server return error with status = ' . $response['status']);
                    }
                }
            }
        }
        if(!is_null($successTransaction)) {

            $transactionData = $successTransaction['receipt']['in_app'];
            usort( $transactionData, function ($a, $b) {
                return strtotime($a['purchase_date']) > strtotime($b['purchase_date']);
            });
            $transactionData = $transactionData[count($transactionData)-1];
            $payment = new Payment();
            $payment->user_id = auth()->id();
            $store_id = $transactionData['product_id'];
            $tariff = Tariff::where('store_id', $store_id)->first();
            if (!$tariff) {
                throw new BaseException('ERR_TARIFF_FIND_FAIL', 422, 'Tariff with store_id = ' . $store_id . ' does not exists');
            }

            $payment->payment_id = $transactionData['transaction_id'];
            $payment->is_confirmed = true;
            $payment->tariff_id = $tariff->id;
            $payment->finished_at = Carbon::now()->addDays($tariff->period);
            $payment->sum = $tariff->admission_price;
            $payment->save();
        }
        return response(null, 200);
    }

    public function sendVerifyReceipt($url, $receiptData)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url,
            [
                RequestOptions::HEADERS => [
                    'Cache-Control' => 'no-cache',
                    'Content-Type' => 'application/json'
                ],
                RequestOptions::JSON => [
                    'receipt-data' => $receiptData,
                    'password' => config('apple.secret')
                ]
            ]);
        return json_decode($response->getBody(), true);
    }
}
