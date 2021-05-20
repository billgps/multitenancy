<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\User\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user('user')->hasVerifiedEmail()) {
            return redirect()->intended(route('user.dashboard').'?verified=1');
        }

        if ($request->user('user')->markEmailAsVerified()) {
            event(new Verified($request->user('user')));
        }

        return redirect()->intended(route('user.dashboard').'?verified=1');
    }
}
