<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteProfileCodeRequest;
use App\Http\Requests\GetCredentialsCodeRequest;
use App\Http\Services\SendCodeService;
use App\Http\Services\SocialsService;
use App\Models\ChangeCredentials;
use App\Models\SocialAccount;
use App\Models\User;
use App\Models\VerifyAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getCredentialsCode(GetCredentialsCodeRequest $request)
    {
        $user = User::find(auth()->id());
        $code = strval(mt_rand(1000, 9999));
        $sendCode = new SendCodeService();
        $changeCredentials = new ChangeCredentials();
        $changeCredentials->token = Hash::make($code);
        $changeCredentials->user_id = $user->id;
        $changeCredentials->created_at = Carbon::now()->setTimezone('Europe/Moscow')->addDay();
        $changeCredentials->is_old_credentials = $request->isOldCredentials;
        switch ($request->grantType) {
            case 'email':
            {
                if (!$request->haveAccessToOldCredentials && !$request->isOldCredentials) {
                    $sendCode->sendEmailWarning($user->email, $request->email);
                    $sendCode->sendEmailCode($request->email, $code);
                    $changeCredentials->email = $request->email;
                } elseif ($request->haveAccessToOldCredentials && $request->isOldCredentials) {
                    $sendCode->sendEmailCode($user->email, $code);
                    $changeCredentials->email = $user->email;
                    $changeCredentials->value = $request->email;
                } elseif (!$request->haveAccessToOldCredentials && $request->isOldCredentials) {
                    if (is_null($user->phone)) {
                        throw new BaseException("ERR_VALIDATION_FAILED_PHONE", 422, __('validation.exists', ['attribute' => 'phone']));
                    }
                    $code = $sendCode->sendPhoneCall($user->phone);
                    $changeCredentials->token = Hash::make($code);
                    $changeCredentials->email = $request->email;
                } else {
                    $sendCode->sendEmailCode($request->email, $code);
                    $changeCredentials->email = $request->email;
                }
                $changeCredentials->save();
                break;
            }
            case 'phone':
            {
                if (!$request->haveAccessToOldCredentials && !$request->isOldCredentials) {
                    $sendCode->sendPhoneWarning($user->phone, $request->phone);
                    $code = $sendCode->sendPhoneCall($request->phone);
                    $changeCredentials->token = Hash::make($code);
                    $changeCredentials->phone = $request->phone;
                } elseif ($request->haveAccessToOldCredentials && $request->isOldCredentials) {
                    $code =  $sendCode->sendPhoneCall($user->phone);
                    $changeCredentials->token = Hash::make($code);
                    $changeCredentials->phone = $user->phone;
                    $changeCredentials->value = $request->phone;
                } elseif (!$request->haveAccessToOldCredentials && $request->isOldCredentials) {
                    if (is_null($user->email)) {
                        throw new BaseException("ERR_VALIDATION_FAILED_EMAIL", 422, __('validation.exists', ['attribute' => 'email']));
                    }
                    $sendCode->sendEmailCode($user->email, $code);
                    $changeCredentials->phone = $request->phone;

                } else {
                    $code = $sendCode->sendPhoneCall($request->phone);
                    $changeCredentials->token = Hash::make($code);
                    $changeCredentials->phone = $request->phone;
                }

                $changeCredentials->save();
                break;
            }
            case 'google':
            case 'apple':
            {
                $socialService = new SocialsService($request->token);
                $socialService->checkIfExists($request->grantType);
                if (isset($request->email)) {
                    $user->email = $request->email;
                }
                if (isset($request->phone)) {
                    $user->phone = $request->phone;
                }
                $user->save();
                break;
            }
        }
        return response(null, 200);
    }

    public function getDeleteProfileCode(DeleteProfileCodeRequest $request)
    {
        $user = User::find(auth()->id());
        $code = strval(mt_rand(1000, 9999));
        $sendCode = new SendCodeService();
        $verify = new VerifyAccount();
        $verify->token = Hash::make($code);
        $verify->created_at = Carbon::now()->setTimezone('Europe/Moscow')->addDay();
        $verify->is_delete = true;
        switch ($request->grantType) {
            case 'email':
            {
                $sendCode->sendEmailCall($user->email, $code);
                $verify->value = $user->email;
                $verify->save();
                break;
            }
            case 'phone':
            {
                $code = $sendCode->sendPhoneCall($user->phone);
                $verify->token = Hash::make($code);
                $verify->phone = $user->phone;
                $verify->save();
                break;
            }
            case 'google':
            case 'apple':
            {
                $socialService = new SocialsService($request->token);
                $socialService->checkIfExists($request->grantType);
                $user->delete();
                break;
            }
        }
        return response(null, 200);
    }
}
