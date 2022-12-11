<?php

namespace App\Http\Services;

use App\Models\ContentRule;
use App\Models\Notification;
use Carbon\Carbon;

class ContentSettingsService
{
    public function getUserData()
    {
        $user = auth()->user();
        $seenLots = $user->seenLots->pluck('id')->toArray();
        $fixedLots = $user->fixedLots->pluck('id')->toArray();
        $hiddenLots = $user->hiddenLots->pluck('id')->toArray();
        $monitorings = $user->monitorings;
        $monitoringLots = [];
        foreach ($monitorings as $monitoring) {
            $monitoringLots = array_merge($monitoringLots, $monitoring->lots()->pluck('lots.id')->toArray());
        }
        $favourites = $user->favourites;
        $favouritesLots = [];
        $notSeenNots = [];
        foreach ($favourites as $favourite) {
            $lotIds = $favourite->lots()->pluck('lots.id')->toArray();
            if (count($lotIds) > 0) {
                $favouritesLots[] = ['path' => $favourite->only('id', 'title', 'color', 'lots_count'), 'lotIds' => $lotIds];
                $notifications = Notification::whereIn('lot_id', $favourite->lots()->pluck('favourite_lot.id'))->where('is_seen', false)->pluck('lot_id');
                $notSeenNots = $favourite->lots()->whereIn('favourite_lot.id', $notifications)->pluck('lots.id')->toArray();
            }

        }
        $rules = $this->getUserContentRules();
        return array(
            'seenLots' => $seenLots,
            'fixedLots' => $fixedLots,
            'hiddenLots' => $hiddenLots,
            'monitoringLots' => $monitoringLots,
            'favouritesLots' => $favouritesLots,
            'notSeenNots' => $notSeenNots,
            'contentRules' => $rules
        );
    }

    public function getUserContentRules(){
        $user = auth()->user();
        $hasTariff = !is_null($user->tariff);
        $hasTestPeriod = $user->email_verified_at->addDays(3) > Carbon::now()->setTimezone('Europe/Moscow');
        $rules = ContentRule::all()->pluck( 'is_available', 'code');
        if ($hasTariff || $hasTestPeriod) {
            foreach ($rules as $key=>$value) {
                $rules[$key] = true;
            }
        }
        return $rules;
    }
}
