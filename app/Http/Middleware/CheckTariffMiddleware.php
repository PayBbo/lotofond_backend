<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomExceptions\BaseException;
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
    public function handle(Request $request, Closure $next)
    {
        $user = User::find(auth()->id());
        if(Carbon::parse($user->email_verified_at)->addDays(3)->format('d.m.Y H:i:s') < Carbon::now()->setTimezone('Europe/Moscow')->format('d.m.Y H:i:s') && !$user->tariff){
            throw new BaseException('ERR_CHECK_TARIFF_FAILED', 403, __('validation.no_activated_tariff'));
        }
        return $next($request);
    }
}
