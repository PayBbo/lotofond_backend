<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Services\SendCodeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function getResetPasswordCode(ResetPasswordRequest $request)
    {
        $code = strval(mt_rand(1000, 9999));
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
                $code = $sendCode->sendPhoneCall($request->phone);
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
}
