<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ASPAKCheck
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
        if (!app('currentTenant')->is_aspak) {
            return redirect()->back()->with('error', 'Tenant ini tidak memiliki persyaratan ASPAK');
        } else {
            return $next($request);
        }
    }
}
