<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Lot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $contacts = Contact::all();
        return response(
            [
                'usersCount'=>$usersCount,
                'newUsersCount'=>$newUsersCount,
                'lotsCount'=>$lotsCount,
                'newLotsCount'=>$newLotsCount,
                'contacts'=>$contacts
            ], 200);
    }

    public function updateContacts(Request $request){
        foreach ($request->contacts as $item){
            $contact = Contact::find($item['id']);
            $contact->contact = $item['contact'];
            $contact->save();
        }
        return response(null, 200);
    }
}
