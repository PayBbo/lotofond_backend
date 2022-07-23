<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Jobs\SendApplication;
use App\Models\User;
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
            foreach ($request->socialsForAnswer as $key=>$social) {
                if(++$key !== $count) {
                    $socials .= $social . ' ,';
                }else{
                    $socials .= $social;
                }
            }
        }
        dispatch(new SendApplication($user->surname . ' ' . $user->name, $request->email,
            $request->phone, $socials, URL::to('/lot/' . $request->lotId)));
        return response(null, 200);
    }
}
