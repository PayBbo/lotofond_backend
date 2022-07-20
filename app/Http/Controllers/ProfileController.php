<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Requests\GetCredentialsCodeRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\VerifyCredentialsCodeRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Services\SendCodeService;
use App\Jobs\ChangeEmail;
use App\Models\ChangeCredentials;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getUser()
    {
        $user_id = auth()->user()->getAuthIdentifier();
        return response(new ProfileResource(User::find($user_id)), 200);
    }

    public function updateUser(UpdateAccountRequest $request)
    {
        $user_id = auth()->user()->getAuthIdentifier();
        $user = User::find($user_id);
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->middle_name = $request->middleName;
        $user->save();
        return response(new ProfileResource(User::find($user_id)), 200);
    }

    public function getCredentialsCode(GetCredentialsCodeRequest $request)
    {
        $user = User::find(auth()->id());
        $code = strval(mt_rand(100000, 999999));
        $sendCode = new SendCodeService();
        $changeCredentials= new ChangeCredentials();
        $changeCredentials->token = Hash::make($code);
        $changeCredentials->user_id = $user->id;
        $changeCredentials->created_at = Carbon::now()->setTimezone('Europe/Moscow')->addDay();
        switch ($request->grantType){
            case 'email':{
                if(!$request->haveAccessToOldCredentials && !$request->isOldCredentials){
                    $sendCode->sendEmailWarning($user->email, $request->email);
                }else{
                    if($request->email == $user->email){
                        $changeCredentials->is_old_credentials = true;
                    }
                }
                $changeCredentials->email = $request->email;
                $sendCode->sendEmailCode($request->email, $code);
                break;
            }
            case 'phone':{
                if($request->phone == $user->phone){
                    $changeCredentials->is_old_credentials = true;
                }
                $changeCredentials->phone = $request->phone;
                $sendCode->sendPhoneCode($request->phone, $code);
                break;
            }
        }
        $changeCredentials->save();
        return response(null, 200);
    }

    public function verifyCredentialsCode(VerifyCredentialsCodeRequest $request)
    {
        switch ($request->grantType){
            case 'email':{
                $changeCredentials = ChangeCredentials::where('email', $request->email)->first();
                break;
            }
            case 'phone':{
                $changeCredentials = ChangeCredentials::where('phone', $request->phone)->first();
                break;
            }
        }
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow')->addDay();
        if (!Hash::check($request->code, $changeCredentials->token) || $changeCredentials->created_at < $currentDate) {
            throw new BaseException("ERR_VALIDATION_FAILED_CODE", 422, __('validation.verification_code'));
        }
        $user = User::find(auth()->id());
        if($request->isOldCredentials && $request->haveAccessToOldCredentials && $user->email == $request->email){
            $changeCredentials->is_submitted_old_credentials = true;
            $changeCredentials->save();
        }elseif($request->haveAccessToOldCredentials && !$request->isOldCredentials){
            if(isset($request->email)){
                $user->email = $request->email;
            }
            if(isset($request->phone)){
                $user->phone = $request->phone;
            }
            $user->save();
            ChangeCredentials::where('user_id', $user->id)->delete();
        }elseif(!$request->haveAccessToOldCredentials && !$request->isOldCredentials){
            dispatch(new ChangeEmail($changeCredentials->id))->delay(now()->setTimezone('Europe/Moscow')->addMinutes(2));
        }else{
            throw new BaseException("ERR_VALIDATION_FAILED_CODE", 422, __('validation.credentials_submitted'));
        }
        return response(null, 200);
    }
}
