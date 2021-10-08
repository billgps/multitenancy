<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // dd($request->is('user*'));
        // if(! $request->expectsJson() && $request->is('user*')) {
        //     return route('user.login');
        // }
        if(! $request->expectsJson() && $request->is('administrator*')) {
            return route('administrator.login');
        }
        if (! $request->expectsJson()) {
            return route('user.login');
        }
    }
}
