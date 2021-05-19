<?php

namespace App\Http\Controllers\Administrator\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\Administrator\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated administrator's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user('administrator')->hasVerifiedEmail()) {
            return redirect()->intended(route('administrator.dashboard').'?verified=1');
        }

        if ($request->user('administrator')->markEmailAsVerified()) {
            event(new Verified($request->user('administrator')));
        }

        return redirect()->intended(route('administrator.dashboard').'?verified=1');
    }
}
