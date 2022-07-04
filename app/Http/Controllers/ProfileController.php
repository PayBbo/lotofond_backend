<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function getUser(){
        $user_id = auth()->user()->getAuthIdentifier();
        return response(User::find($user_id)->only(['name', 'surname', 'middle_name', 'email', 'phone']), 200);
    }

    public function updateUser(UpdateAccountRequest $request){
        $user_id = auth()->user()->getAuthIdentifier();
        $user = User::find($user_id);
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->middle_name = $request->middleName;
        $user->save();
        return response(User::find($user_id)->only(['name', 'surname', 'middle_name', 'email', 'phone']), 200);
    }
}
