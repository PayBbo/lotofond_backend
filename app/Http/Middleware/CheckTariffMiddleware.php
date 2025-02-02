<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomExceptions\BaseException;
use App\Http\Services\CacheService;
use App\Models\ContentRule;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CheckTariffMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $contentRule=null)
    {
        $user = User::find(auth()->guard('api')->id());
        $isAvailable = false;
        if(!is_null($contentRule)){
            $isAvailable = Cache::get('contentRules')[$contentRule];
        }
        if(auth()->guard('api')->check() && !$isAvailable) {
           // $trialPeriod = config('paymaster.trial_period');
            $header = $request->header('TGBot');
            if($header) {
                if(!Cache::has('botTrialPeriod')){
                    $cacheService = new CacheService();
                    $cacheService->cacheBotTrialPeriod();
                }

                $botTrialPeriod = (int)Cache::get('botTrialPeriod');
                if ($user->tg_connected_at &&
                    Carbon::parse($user->tg_connected_at)->addDays($botTrialPeriod)->format('Y-m-d H:i') < Carbon::now()->setTimezone('Europe/Moscow')->format('Y-m-d H:i')
                    && is_null($user->botTariff)
                ) {
                    throw new BaseException('ERR_CHECK_TARIFF_FAILED', 406, __('validation.no_activated_tariff'));
                }
            }
            else  {
                if(!Cache::has('trialPeriod')){
                    $cacheService = new CacheService();
                    $cacheService->cacheTrialPeriod();
                }
                $trialPeriod = (int)Cache::get('trialPeriod');
                if (Carbon::parse($user->email_verified_at)->addDays($trialPeriod)->format('Y-m-d H:i') < Carbon::now()->setTimezone('Europe/Moscow')->format('Y-m-d H:i') && is_null($user->tariff)) {
                    throw new BaseException('ERR_CHECK_TARIFF_FAILED', 406, __('validation.no_activated_tariff'));
                }
            }
        }
        return $next($request);
    }
}
