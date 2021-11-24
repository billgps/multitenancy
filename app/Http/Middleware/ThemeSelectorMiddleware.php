<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Qirolab\Theme\Theme;
use Spatie\Multitenancy\Models\Tenant;

class ThemeSelectorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Tenant::current()) {
            app('currentTenant');
            Theme::set('tenant');
        } else {
            Theme::set('host');
        }

        return $next($request);
    }
}
