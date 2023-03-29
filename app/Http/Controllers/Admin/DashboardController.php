<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lot;
use App\Models\Region;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function checkAdmin(){
        $user = User::find(auth()->id());
        $status = auth()->check() && $user->hasRole('admin');
        $permissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();
        return response(['status'=>$status, 'permissions'=>$permissions], 200);
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

    public function getRegions(){
        $regions = Region::orderBy('title')->get()->pluck('title');
        return response($regions, 200);
    }

}
