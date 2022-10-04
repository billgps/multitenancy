<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|integer',
            'nip' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'position' => 'string|max:255',
            'group' => 'string|max:255',
            'password' => 'required|string|confirmed|min:8',
        ]);
        
        Auth::guard('user')->login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            // 'role' => $request->role,
            'nip' => $request->nip,
            'phone' => $request->phone,
            'position' => $request->position,
            'group' => $request->group,
            'password' => Hash::make($request->password),
        ]));

        if ($request->role == 0) {
            $user->assignRole('admin');
        } 

        else if ($request->role == 1) {
            $user->assignRole('staff');
        }

        else if ($request->role == 3) {
            
            $user->assignRole('nurse');
        }
        
        else {
            $user->assignRole('visit');
        }
    
        VerifyEmail::createUrlUsing(function ($notifiable) {
            return URL::temporarySignedRoute(
                'user.verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );
        });

        event(new Registered($user));

        return redirect(route('user.dashboard'));
    }
}
