<?php

namespace App\Http\Services;

use App\Models\ContentRule;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ContentSettingsService
{
    public function getUserData()
    {
        $user = auth()->user();
        $seenLots = $user->seenLots->pluck('id')->toArray();
        $fixedLots = $user->fixedLots->pluck('id')->toArray();
        $hiddenLots = $user->hiddenLots->pluck('id')->toArray();
        $monitorings = $user->monitorings->pluck('id')->toArray();
        $monitoringLots = DB::table('lot_monitoring')->whereIn('monitoring_id', $monitorings)->pluck('lot_id')->toArray();
        $favouritesPaths = $user->favourites;
        $userId = $user->id;
        $favourites = DB::table('favourite_lot')->whereIn('favourite_id', $favouritesPaths->pluck('id')->toArray())->pluck('id')->toArray();
        $favouritesLots = DB::table('favourite_lot')->whereIn('favourite_id', function($query) use ($userId)
        {
            $query->select('id')
                ->from('favourites')
                ->where("favourites.user_id", $userId);
        })->pluck('lot_id')->toArray();
        $notifications = Notification::whereIn('lot_id', $favourites)->where('is_seen', false)->pluck('lot_id')->toArray();
        $favNotSeen = array_intersect($notifications, $favourites);
        $notSeenNots = DB::table('favourite_lot')->whereIn('id', $favNotSeen)->pluck('lot_id')->toArray();
        $rules = $this->getUserContentRules();
        return array(
            'seenLots' => $seenLots,
            'fixedLots' => $fixedLots,
            'hiddenLots' => $hiddenLots,
            'monitoringLots' => $monitoringLots,
            'favouritesLots' => $favouritesLots,
            'notSeenNots' => $notSeenNots,
            'contentRules' => $rules,
            'favouritePaths'=>$favouritesPaths
        );
    }

    public function getUserContentRules()
    {
        $user = auth()->user();
        $hasTariff = !is_null($user->tariff);
        $hasTestPeriod = $user->email_verified_at->addDays(3) > Carbon::now()->setTimezone('Europe/Moscow');
        $rules = ContentRule::all()->pluck('is_available', 'code');
        if ($hasTariff || $hasTestPeriod) {
            foreach ($rules as $key => $value) {
                $rules[$key] = true;
            }
        }
        return $rules;
    }
}
