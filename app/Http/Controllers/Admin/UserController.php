<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function get(Request $request)
    {
        $searchString = $request->query('param');
        $users = User::when(isset($searchString), function($query) use ($searchString){
            $query->where('email', 'LIKE', '%'.$searchString.'%')
                ->orWhere('phone', 'LIKE', '%'.$searchString.'%')
                ->orWhere('name', 'LIKE', '%'.$searchString.'%')
                ->orWhere('surname', 'LIKE', '%'.$searchString.'%');
        })->paginate(20);
        return response(new UserCollection($users), 200);
    }

    public function update(Request $request){
        $user = User::find($request->id);
        if($user){
            if($user->hasRole('admin')){
                $user->removeRole('admin');
            }else{
                $user->assignRole('admin');
            }
        }
        return response(null, 200);
    }
}
