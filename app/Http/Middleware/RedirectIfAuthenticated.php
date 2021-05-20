<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if(in_array('user', $guards, true) && Auth::guard('user')->check()) {
            return redirect(route('user.dashboard'));
        }
        if(in_array('tenant', $guards, true) && Auth::guard('tenant')->check()) {
            return redirect(route('tenant.dashboard'));
        }
        if(in_array('administrator', $guards, true) && Auth::guard('administrator')->check()) {
            return redirect(route('administrator.dashboard'));
        }
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
