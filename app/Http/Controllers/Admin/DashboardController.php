<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getDashboardData(){
        $usersCount = User::count();
        return response(['usersCount'=>$usersCount], 200);
    }
}
