<?php

namespace App\Http\Controllers\Administrator\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('administrator.auth.confirm-password');
    }

    /**
     * Confirm the administrator's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (! Auth::guard('administrator')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            return back()->withErrors([
                'password' => __('administrator.auth.password'),
            ]);
        }

        $request->session()->put('administrator.auth.password_confirmed_at', time());

        return redirect()->intended(route('administrator.dashboard'));
    }
}
