<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\VerifyResetPasswordRequest;
use App\Http\Resources\AccessTokenResource;
use App\Http\Services\GenerateAccessTokenService;
use App\Http\Services\SendCodeService;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function getResetPasswordCode(ResetPasswordRequest $request)
    {
        $code = strval(mt_rand(100000, 999999));
        $sendCode = new SendCodeService();
        switch ($request->grantType) {
            case 'email':
            {
                $username = $request->email;
                $sendCode->sendEmailCode($request->email, $code);
                break;
            }
            case 'phone':
            {
                $username = $request->phone;
                $sendCode->sendPhoneCode($request->email, $code);
                break;
            }
        }
        if (DB::table('password_resets')->where('email', $username)->exists()) {
            DB::table('password_resets')->where('email', $username)->delete();
        }
        DB::table("password_resets")->insert([
            "email" => $username,
            "token" => Hash::make($code),
            "created_at" => Carbon::now()->addDay()
        ]);
        return response(null, 200);
    }

    public function verifyResetPasswordCode(VerifyResetPasswordRequest $request)
    {
        switch ($request->grantType) {
            case 'email':
            {
                $username = $request->email;
                break;
            }
            case 'phone':
            {
                $username = $request->phone;
                break;
            }
        }
        $passwordReset = DB::table('password_resets')->where('email', $username)->where('created_at', '>', Carbon::now())->first();
        if ($passwordReset == null || !Hash::check($request->code, $passwordReset->token)) {
            throw new BaseException("ERR_VALIDATION_FAILED", 422, "Reset Password Code doesn't match our credentials");
        }
        return response(null, 200);

    }


    public function resetPassword(VerifyResetPasswordRequest $request)
    {
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
            throw new BaseException("ERR_VALIDATION_FAILED", 422, "Reset Password Code doesn't match our credentials");
        }
        DB::table('password_resets')->where('email', $username)->delete();
        $user->password = Hash::make($request->password);
        $user->save();
        $generateToken = new GenerateAccessTokenService();
        $token = $generateToken->generateToken($request, $username, $request->password);
        return response($token, 200);

    }
}
