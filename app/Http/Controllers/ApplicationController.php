<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\ContactsRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\ReceiptRequest;
use App\Http\Services\PaymentService;
use App\Http\Services\SendCodeService;
use App\Jobs\SendApplication;
use App\Models\Application;
use App\Models\Contact;
use App\Models\Lot;
use App\Models\Payment;
use App\Models\Tariff;
use App\Models\User;
use App\Notifications\ApplicationTelegramNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ApplicationController extends Controller
{
    public function sendApplication(ApplicationRequest $request)
    {
        $user = User::find(auth()->id());
        $socials = 'Не указаны';
        if (gettype($request->socialsForAnswer) == 'array') {
            $socials = '';
            $count = count($request->socialsForAnswer);
            foreach ($request->socialsForAnswer as $key => $social) {
                if (++$key !== $count) {
                    $socials .= $social . ' ,';
                } else {
                    $socials .= $social;
                }
            }
        }
        $services = Tariff::whereIn('code', $request->paymentTradingTypes)->get();
        foreach ($services as $service) {
            $application = Application::create([
                'user_id' => auth()->id(),
                'lot_id' => $request->lotId,
                'email' => $request->email,
                'phone' => $request->phone,
                'for_answer' => $socials,
                'answer_date' => $request->dateForCallback,
                'username' => $request->name ?? $user->surname . ' ' . $user->name,
                'tariff_id' => $service->id
            ]);
            $sendEmail = new SendCodeService();
            $sendEmail->sendApplicationToManager($application);
        }
        return response(null, 200);
    }

    public function sendQuestion(QuestionRequest $request)
    {
        $user = User::find(auth()->id());
        $username = $user->surname . ' ' . $user->name;
        $files = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = str_replace(" ", "-", $file->getClientOriginalName());
                Storage::disk('public')->put('questions/user-' . auth()->id() . '/' . $filename, File::get($file));
                $files[] = 'questions/user-' . auth()->id() . '/' . $filename;
            }
        }
        $service = Tariff::where('code', 'newQuestion')->first();
        $application = Application::create([
            'user_id' => auth()->id(),
            'email' => $request->email,
            'topic' => $request->topic,
            'question' => $request->question,
            'username' => $username,
            'files' => $files,
            'tariff_id' => $service->id
        ]);
        $sendEmail = new SendCodeService();
        $sendEmail->sendQuestionToManager($application);

        return response(null, 200);
    }

    public function sendContacts(ContactsRequest $request)
    {
        $service = Tariff::where('code', 'newQuestion')->first();
        $application = Application::create([
            'email' => $request->communicationType == 'email' ? $request->communication : null,
            'phone' => $request->communicationType == 'phone' ? $request->communication : null,
            'question' => $request->question,
            'tariff_id' => $service->id
        ]);
        $sendEmail = new SendCodeService();
        $sendEmail->sendContactsToManager($application);
        return response(null, 200);
    }

    public function receiptEgrn(ReceiptRequest $request)
    {
        $url = $this->buyService($request, 'receiptEGRN');
        return response([
            'redirectUrl' => $url
        ], 200);
    }

    public function purchaseInstructions(PurchaseRequest $request)
    {
        $url = $this->buyService($request, 'purchaseInstructions');
        return response([
            'redirectUrl' => $url
        ], 200);

    }

    public function buyService($request, $code)
    {
        $service = Tariff::where('code', $code)->first();
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'sum' => $service->price,
            'tariff_id' => $service->id
        ]);
        $application = new Application();
        $application->user_id = auth()->id();
        $application->lot_id = $request->lotId;
        $lotDesc = mb_strimwidth(Lot::find($request->lotId)['description'], 0, 100, "...");
        $description = $service->description .' для лота - '.$lotDesc;
        $customer = null;
        if (isset($request->email)) {
            $application->email = $request->email;
            $customer = ['email' => $request->email];
        }
        if (isset($request->cadastralNumber)) {
            $application->cadastral_number = $request->cadastralNumber;
        }
        if(isset($request->answerFormat)){
            $application->format = $request->answerFormat;
        }
        $application->tariff_id = $service->id;
        $application->payment_id = $payment->id;
        $application->save();

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
