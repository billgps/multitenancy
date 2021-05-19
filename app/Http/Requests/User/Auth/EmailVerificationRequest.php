<?php

namespace App\Http\Requests\User\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest as Existing;

class EmailVerificationRequest extends Existing
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! hash_equals((string) $this->route('id'),
            (string) $this->user('user')->getKey())) {
            return false;
        }

        if (! hash_equals((string) $this->route('hash'),
            sha1($this->user('user')->getEmailForVerification()))) {
            return false;
        }

        return true;
    }

    /**
     * Fulfill the email verification request.
     *
     * @return void
     */
    public function fulfill()
    {
        if (! $this->user('user')->hasVerifiedEmail()) {
            $this->user('user')->markEmailAsVerified();

            event(new Verified($this->user('user')));
        }
    }
}
