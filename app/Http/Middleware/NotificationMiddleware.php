<?php

namespace App\Http\Middleware;

use App\Models\Administrator;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\Notification;

class NotificationMiddleware
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
        if (Auth::user()) {
            if (Tenant::current()) {
                $user = User::find(Auth::user()->id);
            } else {
                $user = Administrator::find(Auth::user()->id);
            }
            
            $notifications = $user->unreadNotifications()->limit(50)->get();
            $request->session()->put('notifications', $notifications);
        }

        return $next($request);
    }
}
