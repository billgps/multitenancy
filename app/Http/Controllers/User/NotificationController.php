<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function ajax() 
    {
        $user = User::find(Auth::user()->id);
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }

        return response()->json($user->unreadNotifications->count(), 200);
    }
}
