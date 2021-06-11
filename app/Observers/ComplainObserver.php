<?php

namespace App\Observers;

use App\Models\Complain;
use App\Models\User;
use App\Notifications\ComplainUpdate;
use Illuminate\Support\Facades\Notification;

class ComplainObserver
{
    /**
     * Handle the Complain "created" event.
     *
     * @param  \App\Models\Complain  $complain
     * @return void
     */
    public function created(Complain $complain)
    {
        $users = User::where('role', 1)->get();

        Notification::send($users, new ComplainUpdate($complain, ' membuat komplain baru'));
    }

    /**
     * Handle the Complain "updated" event.
     *
     * @param  \App\Models\Complain  $complain
     * @return void
     */
    public function updated(Complain $complain)
    {
        //
    }

    /**
     * Handle the Complain "deleted" event.
     *
     * @param  \App\Models\Complain  $complain
     * @return void
     */
    public function deleted(Complain $complain)
    {
        //
    }

    /**
     * Handle the Complain "restored" event.
     *
     * @param  \App\Models\Complain  $complain
     * @return void
     */
    public function restored(Complain $complain)
    {
        //
    }

    /**
     * Handle the Complain "force deleted" event.
     *
     * @param  \App\Models\Complain  $complain
     * @return void
     */
    public function forceDeleted(Complain $complain)
    {
        //
    }
}
