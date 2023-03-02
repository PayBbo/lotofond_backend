<?php

namespace App\Http\Services;

use App\Models\ContentRule;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContentSettingsService
{
    protected $contentRules;
    protected $authCheck;
    protected $user;

    public function __construct(){

        $this->authCheck = auth()->guard('api')->check();
        $this->user = auth()->user();
        $this->contentRules = $this->getUserContentRules();

    }

    public function getUserData()
    {
        $user = $this->user;
        $seenLots = DB::table('seen_lots')->where('user_id', $user->id)->pluck('lot_id')->toArray();
        $fixedLots = DB::table('fixed_lots')->where('user_id', $user->id)->pluck('lot_id')->toArray();
        $hiddenLots = DB::table('hidden_lots')->where('user_id', $user->id)->pluck('lot_id')->toArray();
        $monitorings = DB::table('monitorings')->where('user_id', $user->id)->pluck('id')->toArray();
        $monitoringLots = DB::table('lot_monitoring')->whereIn('monitoring_id', $monitorings)->pluck('lot_id')->toArray();
        $favourites = $user->favourites()->with('lots');
        $favouritesLots = [];
        $lots = [];
        foreach ($favourites as $favourite) {
            $lotIds = $favourite->lots->pluck('lots.id')->toArray();

            if (count($lotIds) > 0) {
                $lots = array_merge($lots, $favourite->lots()->pluck('favourite_lot.id')->toArray());
                $favourite = $favourite->only('id', 'title', 'color');
                $favourite['lots_count'] = count($lotIds);
                $favouritesLots[] = ['path' => $favourite, 'lotIds' => $lotIds];
            }

        }
        $favNotSeen = Notification::whereIn('lot_id', $lots)->where('is_seen', false)->pluck('lot_id')->toArray();
        $notSeenNots = DB::table('favourite_lot')->whereIn('id', $favNotSeen)->pluck('lot_id')->toArray();

        return array(
            'seenLots' => $seenLots,
            'fixedLots' => $fixedLots,
            'hiddenLots' => $hiddenLots,
            'monitoringLots' => $monitoringLots,
            'favouritesLots' => $favouritesLots,
            'notSeenNots' => $notSeenNots
        );
    }

    public function getUserContentRules()
    {
        $hasTariff = false;
        $hasTestPeriod = false;
        $trialPeriod = config('paymaster.trial_period');
        if($this->authCheck) {
            $user = $this->user;
            $hasTariff = !is_null($user->tariff);
            $hasTestPeriod = $user->email_verified_at->addDays($trialPeriod)->format('Y-m-d H:i') >= Carbon::now()->setTimezone('Europe/Moscow')->format('Y-m-d H:i');
        }
        if(!Cache::has('contentRules')){
            Cache::forever('contentRules', ContentRule::all()->pluck('is_available', 'code'));
        }
        $rules = Cache::get('contentRules');
        if ($hasTariff || $hasTestPeriod) {
            foreach ($rules as $key => $value) {
                $rules[$key] = true;
            }
        }
        return $rules;
    }

    public function isAvailable($code)
    {
        return $this->contentRules[$code];
    }
}
