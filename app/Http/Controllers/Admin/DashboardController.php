<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lot;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function checkAdmin(){
        $user = User::find(auth()->id());
        $status = auth()->check() && $user->hasRole('admin');
        return response(['status'=>$status], 200);
    }

    public function getDashboardData(){
        $date = Carbon::now()->setTimezone('Europe/Moscow');
        $usersCount = User::count();
        $lotsCount = Lot::count();
        $newLotsCount = Lot::whereDate('created_at',$date)->count();
        $newUsersCount = User::whereDate('created_at',$date)->count();
        return response(
            [
                'usersCount'=>$usersCount,
                'newUsersCount'=>$newUsersCount,
                'lotsCount'=>$lotsCount,
                'newLotsCount'=>$newLotsCount
            ], 200);
    }

}
