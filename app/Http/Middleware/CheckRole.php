<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomExceptions\BaseException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        $user = User::find(auth()->id());
        if(auth()->check() && $user->hasRole($role)) {
            return $next($request);
        }else{
            abort(403);
        }
    }
}
