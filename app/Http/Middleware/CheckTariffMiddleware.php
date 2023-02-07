<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomExceptions\BaseException;
use App\Models\ContentRule;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

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
            $isAvailable = ContentRule::where('code', $contentRule)->first()['is_available'];
        }
        if(auth()->guard('api')->check() && !$isAvailable) {
            $trialPeriod = config('paymaster.trial_period');
            if (Carbon::parse($user->email_verified_at)->addDays($trialPeriod)->format('Y-m-d H:i') < Carbon::now()->setTimezone('Europe/Moscow')->format('Y-m-d H:i') && is_null($user->tariff)) {
                throw new BaseException('ERR_CHECK_TARIFF_FAILED', 406, __('validation.no_activated_tariff'));
            }
        }
        return $next($request);
    }
}
