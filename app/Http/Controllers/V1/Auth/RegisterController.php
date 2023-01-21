<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResendRegistrationCodeRequest;
use App\Http\Services\GenerateAccessTokenService;
use App\Http\Services\SendCodeService;
use App\Http\Services\SocialsService;
use App\Models\SocialAccount;
use App\Models\User;
use App\Models\VerifyAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $code = strval(mt_rand(1000, 9999));
        $sendCode = new SendCodeService();
        $verify = new VerifyAccount();
        $verify->surname = $request->surname;
        $verify->name = $request->name;
        $verify->token = Hash::make($code);
        $verify->code = $request->password;
        $verify->created_at = Carbon::now()->setTimezone('Europe/Moscow')->addDay();
        $verify->is_delete = false;
        switch ($request->grantType) {
            case 'email':
            {
                $verify->value = $request->email;
                $sendCode->sendEmailCode($request->email, $code);
                break;
            }
            case 'phone':
            {
                $verify->phone = $request->phone;
                $code = $sendCode->sendPhoneCall($request->phone);
                $verify->token = Hash::make($code);
                break;
            }
            case 'google':
            case 'apple':
            {
                $socialService = new SocialsService($request->token);
                $token = $socialService->saveUser($request);
                return response($token, 200);
                break;
            }
            /* case 'gosuslugi':{
                 //
                 break;
             }*/
        }
        $verify->save();
        return response(null, 200);
    }

    public function requestRegistrationCode(ResendRegistrationCodeRequest $request)
    {
        $code = strval(mt_rand(1000, 9999));
        $sendCode = new SendCodeService();
        switch ($request->grantType) {
            case 'email':
            {
                $verifyAccount = VerifyAccount::where('value', $request->email)->first();
                $sendCode->sendEmailCode($request->email, $code);
                break;
            }
            case 'phone':
            {
                $verifyAccount = VerifyAccount::where('phone', $request->phone)->first();
                $code = $sendCode->sendPhoneCall($request->phone);
                break;
            }
        }
        $verifyAccount->token = Hash::make($code);
        $verifyAccount->created_at = Carbon::now()->setTimezone('Europe/Moscow')->addDay();
        $verifyAccount->save();
        return response(null, 200);
    }

}
