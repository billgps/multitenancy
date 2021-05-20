<?php

namespace App\Http\Requests\Administrator\Auth;

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
            (string) $this->user('administrator')->getKey())) {
            return false;
        }

        if (! hash_equals((string) $this->route('hash'),
            sha1($this->user('administrator')->getEmailForVerification()))) {
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
        if (! $this->user('administrator')->hasVerifiedEmail()) {
            $this->user('administrator')->markEmailAsVerified();

            event(new Verified($this->user('administrator')));
        }
    }
}
