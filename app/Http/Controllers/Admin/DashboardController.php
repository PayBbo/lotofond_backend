<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\CacheService;
use App\Models\Lot;
use App\Models\Region;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
        $settings = Setting::all()->pluck( 'value', 'variable')->toArray();
        return response(
            [
                'usersCount'=>$usersCount,
                'newUsersCount'=>$newUsersCount,
                'lotsCount'=>$lotsCount,
                'newLotsCount'=>$newLotsCount,
                'trialPeriod'=>(int)$settings['trial_period'],
                'botTrialPeriod'=>(int)$settings['bot_trial_period'],
                'watermark'=>[
                    'text'=>$settings['watermark_text'],
                    'image'=>URL::to('storage/watermark/'.$settings['watermark_image'])
                    ]
            ], 200);
    }

    public function getRegions(){
        $regions = Region::orderBy('title')->get()->pluck('title');
        return response($regions, 200);
    }

    public function changeWatermark(Request $request){
        $this->validate($request, [
            'image' => 'sometimes|mimes:jpg,png,jpeg,bmp|max:10240',
            'text'=>'required|string'
        ]);
        $watermarkText = Setting::where('variable', 'watermark_text')->first();
        $watermarkText->value = $request->text;
        $watermarkText->save();

        if(isset($request->image)) {
            $filename = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('watermark/', $filename, 'public');
            $watermarkImage = Setting::where('variable', 'watermark_image')->first();
            if($filename != $watermarkImage->value) {
                Storage::disk('public')->delete('watermark/' . $watermarkImage->value);
            }
            $watermarkImage->value = $filename;
            $watermarkImage->save();
        }

        return response(null, 200);
    }

    public function changeTrialPeriod(Request $request){
        $this->validate($request, [
            'trialPeriod' => 'required|integer|min:0'
        ]);

        $trialPeriod = Setting::where('variable', 'trial_period')->first();
        $trialPeriod->value = $request->trialPeriod;
        $trialPeriod->save();
        $cacheService = new CacheService();
        $cacheService->cacheTrialPeriod();
        return response(null, 200);
    }

    public function changeBotTrialPeriod(Request $request){
        $this->validate($request, [
            'botTrialPeriod' => 'required|integer|min:0'
        ]);

        $trialPeriod = Setting::where('variable', 'bot_trial_period')->first();
        $trialPeriod->value = $request->botTrialPeriod;
        $trialPeriod->save();
        $cacheService = new CacheService();
        $cacheService->cacheBotTrialPeriod();
        return response(null, 200);
    }

}
