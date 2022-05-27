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
        $sendCode->sendEmailCode($request->email, $code);
        VerifyAccount::create([
            'surname' => $request->surname,
            'name' => $request->name,
            'phone' => $request->phone,
            'value' => $request->email,
            'token' => Hash::make($code),
            'code' => $request->password
        ]);

        return response(null, 200);
    }

    public function requestRegistrationCode(ResendRegistrationCodeRequest $request)
    {
        $code = strval(mt_rand(100000, 999999));
        $sendCode = new SendCodeService();
        $sendCode->sendEmailCode($request->email, $code);
        $verifyAccount = VerifyAccount::where('value', $request->email)->first();
        $verifyAccount->token = Hash::make($code);
        $verifyAccount->save();
        return response(null, 200);
    }

    public function verifyRegistrationCode(VerifyRegistrationCodeRequest $request)
    {
        $verifyAccount = VerifyAccount::where('value', $request->email)->first();
        if (!Hash::check($request->code, $verifyAccount->token)) {
            throw new BaseException("ERR_VALIDATION_FAILED", 422, "Verification code doesn't match our credentials");
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
        $generateToken = new GenerateAccessTokenService();
        $token = $generateToken->generateToken($request, $user->email, $password);
        return response(new AccessTokenResource($token), 200);
    }


}
