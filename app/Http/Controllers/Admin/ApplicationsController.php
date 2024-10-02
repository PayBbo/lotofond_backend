<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ApplicationCollection;
use App\Http\Resources\Admin\ApplicationResource;
use App\Http\Services\PaymentService;
use App\Models\Application;
use App\Models\Lot;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApplicationsController extends Controller
{
    /**
     * Проверка прав на совершение действий
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:application-list', ['only' => ['get']]);
        $this->middleware('permission:application-edit', ['only' => ['update']]);
    }

    public function get(Request $request)
    {
        $search = $request->query('pattern', null);
        $date = $request->query('date', null);
        $sortParam = $request->query('sort_property');
        $sortDirection = $request->query('sort_direction');
        $applications = Application::when(isset($search), function ($query) use ($search) {
            $query->where('email', 'LIKE', '%' . $search . '%')
                ->orWhere('username', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'LIKE', '%' . $search . '%')
                ->orWhere('topic', 'LIKE', '%' . $search . '%')
                ->orWhere('question', 'LIKE', '%' . $search . '%')
                ->orWhere('cadastral_number', 'LIKE', '%' . $search . '%');
        })
            ->leftJoin('tariffs as tariff', 'tariff.id', '=', 'applications.tariff_id')
            ->select('applications.*', 'tariff.title->ru as type')
            ->when(isset($date), function ($query) use ($date) {
                $query->where('created_at', $date);
            })
            ->when(isset($sortParam) && isset($sortDirection), function ($query) use ($sortParam, $sortDirection) {
                $query->orderBy($sortParam, $sortDirection);
            })
            ->paginate(20);
        return response(new ApplicationCollection($applications), 200);
    }

    public function update(Request $request)
    {
        $application = Application::find($request->id);
        if ($application) {
            $application->status = $request->status;
            $application->save();
            return response(null, 200);
        }
        return response(null, 404);
    }

    public function show($id)
    {
        $application = Application::where('id', $id)
            ->leftJoin('tariffs as tariff', 'tariff.id', '=', 'applications.tariff_id')
            ->select('applications.*', 'tariff.title->ru as type')
            ->first();
        if (!$application) {
            return response(null, 404);
        }
        return response(new ApplicationResource($application), 200);
    }

    public function generatePaymentUrl(Request $request) {
        $application = Application::find($request->id);
        $service = Tariff::where('id', $application->tariff_id)->first();
        $payment = Payment::find($application->payment_id);
        if(!$payment) {
            $payment = Payment::create([
                'user_id' => $application->user_id,
                'sum' => $service->price,
                'tariff_id' => $service->id
            ]);
        }

        $description = $service->description;
        if($application->lot_id) {
            $lotDesc = mb_strimwidth(Lot::find($application->lot_id)['description'], 0, 100, "...");
            $description .=' для лота - '.$lotDesc;
        }
        $customer = null;
        if ($application->email) {
            $customer = ['email' => $application->email];
        }

        $paymentService = new PaymentService();
        $paymentRequest = $paymentService->paymentRequest($payment->id, $service, $customer, $description);
        if (array_key_exists('paymentId', $paymentRequest)) {
            $paymentId = $paymentRequest['paymentId'];
            $payment->payment_id = $paymentId;
            $payment->token = hash('sha256', $payment->id);
            $payment->save();
            return $paymentRequest['url'];

        }
        throw new BaseException('ERR_CREATE_PAYMENT_FAILED', 403, $paymentRequest);
    }
}
