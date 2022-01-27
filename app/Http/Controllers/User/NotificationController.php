<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Multitenancy\Models\Tenant;

class NotificationController extends Controller
{
    public function ajax() 
    {
        if (Tenant::current()) {
            $user = User::find(Auth::user()->id);
        } else {
            $user = Administrator::find(Auth::user()->id);
        }
        
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }

        return response()->json($user->unreadNotifications->count(), 200);
    }

    public function routing(Notification $notification)
    {
        $notification->markAsRead();

        return redirect($notification->data['url']);
    }

    public function markAllAsRead()
    {

    }
}
