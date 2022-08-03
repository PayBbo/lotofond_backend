<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\GetCredentialsCodeRequest;
use App\Http\Requests\LinkSocialsRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdateNotificationsRequest;
use App\Http\Requests\VerifyCredentialsCodeRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Services\SendCodeService;
use App\Http\Services\SocialsService;
use App\Jobs\ChangeEmail;
use App\Models\ChangeCredentials;
use App\Models\SocialAccount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
        $user->surname = $request->lastName;
        $user->middle_name = $request->middleName;
        $user->save();
        return response(new ProfileResource(User::find($user_id)), 200);
    }

    public function updateNotificationsSettings(UpdateNotificationsRequest $request){
        $user_id = auth()->user()->getAuthIdentifier();
        $user = User::find($user_id);
        $user->not_from_favourite = $request->notificationsFromFavourite;
        $user->not_from_monitoring = $request->notificationsFromMonitoring;
        $user->not_settings = $request->notificationsSettings;
        $user->save();

        return response(null, 200);

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
        $changeCredentials->is_old_credentials = $request->isOldCredentials;
        switch ($request->grantType){
            case 'email':{
                if(!$request->haveAccessToOldCredentials && !$request->isOldCredentials){
                    $sendCode->sendEmailWarning($user->email, $request->email);
                }elseif(!$request->haveAccessToOldCredentials && $request->isOldCredentials){
                    if(is_null($user->phone)){
                        throw new BaseException("ERR_INCORRECT_DATA", 422, 'Value does not exist');
                    }
                    $sendCode->sendPhoneCode($user->phone, $code);
                }
                else{
                    $sendCode->sendEmailCode($request->email, $code);
                }
                $changeCredentials->email = $request->email;

                break;
            }
            case 'phone':{
                if(!$request->haveAccessToOldCredentials && !$request->isOldCredentials){
                    $sendCode->sendPhoneWarning($user->phone, $request->phone);
                }elseif(!$request->haveAccessToOldCredentials && $request->isOldCredentials){
                    if(is_null($user->email)){
                        throw new BaseException("ERR_INCORRECT_DATA", 422, 'Value does not exist');
                    }
                    $sendCode->sendEmailCode($user->email, $code);

                }else{
                    $sendCode->sendPhoneCode($request->phone, $code);
                }
                $changeCredentials->phone = $request->phone;
                break;
            }
        }
        $changeCredentials->save();
        return response(null, 200);
    }

    public function verifyCredentialsCode(VerifyCredentialsCodeRequest $request)
    {
        $user = User::find(auth()->id());
        switch ($request->grantType){
            case 'email':{
                $changeCredentials = ChangeCredentials::where('email', $request->email)->first();
                $isOldCredentials = $user->email == $request->email;
                break;
            }
            case 'phone':{
                $changeCredentials = ChangeCredentials::where('phone', $request->phone)->first();
                $isOldCredentials = $user->phone == $request->phone;
                break;
            }
        }
        $currentDate = Carbon::now()->setTimezone('Europe/Moscow')->addDay();
        if (!Hash::check($request->code, $changeCredentials->token) || $changeCredentials->created_at < $currentDate) {
            throw new BaseException("ERR_VALIDATION_FAILED_CODE", 422, __('validation.verification_code'));
        }
        if($request->isOldCredentials && $request->haveAccessToOldCredentials && $isOldCredentials){
            $changeCredentials->is_submitted_old_credentials = true;
            $changeCredentials->save();
        }elseif(($request->haveAccessToOldCredentials && !$request->isOldCredentials)
            || (!$request->haveAccessToOldCredentials && $request->isOldCredentials)){
            if(isset($request->email)){
                $user->email = $request->email;
            }
            if(isset($request->phone)){
                $user->phone = $request->phone;
            }
            $user->save();
            ChangeCredentials::where('user_id', $user->id)->delete();
        }elseif(!$request->haveAccessToOldCredentials && !$request->isOldCredentials){
            dispatch(new ChangeEmail($changeCredentials->id))->delay(now()->setTimezone('Europe/Moscow')->addWeeks(2));
        }else{
            throw new BaseException("ERR_VALIDATION_FAILED_CODE", 422, __('validation.credentials_submitted'));
        }
        return response(null, 200);
    }

    public function changePassword(ChangePasswordRequest $request){
        switch ($request->grantType) {
            case 'email':
            {
                $username = $request->email;
                $user = User::where('email', $request->email)->first();
                break;
            }
            case 'phone':
            {
                $username = $request->phone;
                $user = User::where('phone', $request->phone)->first();
                break;
            }
        }
        $passwordReset = DB::table('password_resets')->where('email', $username)->where('created_at', '>', Carbon::now())->first();
        if ($passwordReset == null || !Hash::check($request->code, $passwordReset->token)) {
            throw new BaseException("ERR_VALIDATION_FAILED_CODE", 422, __('validation.verification_code'));
        }

        DB::table('password_resets')->where('email', $username)->delete();
        $user->password = Hash::make($request->newPassword);
        $user->save();

        return response(null, 200);
    }

    public function linkSocials(LinkSocialsRequest $request){
        $socialService = new SocialsService();
        $socialService->setToken($request->token);
        $sub = $socialService->getSub();
        $social = SocialAccount::where(['provider_id' => $sub, 'provider' => $request->grantType])->first();
        if($social){
            throw new BaseException("ERR_VALIDATION_FAILED_SOCIALS", 422, __('validation.user_not_found'));
        }
        SocialAccount::create([
           'user_id'=>auth()->id(),
           'provider_id'=>$sub,
           'provider'=>$request->grantType
        ]);
        return response(null, 200);
    }
}
