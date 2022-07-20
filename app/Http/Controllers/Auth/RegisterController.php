<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResendRegistrationCodeRequest;
use App\Http\Requests\VerifyRegistrationCodeRequest;
use App\Http\Resources\AccessTokenResource;
use App\Http\Services\GenerateAccessTokenService;
use App\Http\Services\SendCodeService;
use App\Models\Favourite;
use App\Models\Notification;
use App\Models\User;
use App\Models\VerifyAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $code = strval(mt_rand(100000, 999999));
        $sendCode = new SendCodeService();
        $verify = new VerifyAccount();
        $verify->surname = $request->surname;
        $verify->name = $request->name;
        $verify->token = Hash::make($code);
        $verify->code = $request->password;
        $verify->created_at = Carbon::now()->setTimezone('Europe/Moscow')->addDay();
        switch ($request->grantType){
            case 'email':{
                $verify->value = $request->email;
                $sendCode->sendEmailCode($request->email, $code);
                break;
            }
            case 'phone':{
                $verify->phone = $request->phone;
                $sendCode->sendPhoneCode($request->phone, $code);
                break;
            }
            case 'gosuslugi':{
                //
                break;
            }
        }
        $verify->save();
        return response(null, 200);
    }

    public function requestRegistrationCode(ResendRegistrationCodeRequest $request)
    {
        $code = strval(mt_rand(100000, 999999));
        $sendCode = new SendCodeService();
        switch ($request->grantType){
            case 'email':{
                $verifyAccount = VerifyAccount::where('value', $request->email)->first();
                $sendCode->sendEmailCode($request->email, $code);
                break;
            }
            case 'phone':{
                $verifyAccount = VerifyAccount::where('phone', $request->phone)->first();
                $sendCode->sendPhoneCode($request->phone, $code);
                break;
            }
        }
        $verifyAccount->token = Hash::make($code);
        $verifyAccount->created_at = Carbon::now()->setTimezone('Europe/Moscow')->addDay();
        $verifyAccount->save();
        return response(null, 200);
    }

    public function verifyRegistrationCode(VerifyRegistrationCodeRequest $request)
    {
        switch ($request->grantType){
            case 'email':{
                $verifyAccount = VerifyAccount::where('value', $request->email)->first();
                $username = $request->email;
                break;
            }
            case 'phone':{
                $verifyAccount = VerifyAccount::where('phone', $request->phone)->first();
                $username = $request->phone;
                break;
            }
        }
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow')->addDay();
        if (!Hash::check($request->code, $verifyAccount->token) || $verifyAccount->created_at < $currentDate) {
            throw new BaseException("ERR_VALIDATION_FAILED_CODE", 422, __('validation.verification_code'));
        }
        $password = $verifyAccount->code;
        $user = User::create([
            'surname' => $verifyAccount->surname,
            'name' => $verifyAccount->name,
            'email' => $verifyAccount->value,
            'phone' => $verifyAccount->phone,
            'password' => Hash::make($password),
            'email_verified_at' => Carbon::now()
        ]);
        $verifyAccount->delete();
        Favourite::create([
            'user_id'=>$user->id,
            'title'=>'Общее'
        ]);
        Notification::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->setTimezone('Europe/Moscow'),
            'type_id' => 1,
            'message' => 'gladToSeeYou',
            'label'=> 'welcome',
            'platform_action'=>'info'
        ]);
        $generateToken = new GenerateAccessTokenService();
        $token = $generateToken->generateToken($request, $username, $password);
        return response($token, 200);
    }


}
