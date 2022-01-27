<?php

namespace App\Observers;

use App\Models\Response;
use App\Models\User;
use App\Notifications\ResponseUpdate;
use Illuminate\Support\Facades\Notification;

class ResponseObserver
{
    /**
     * Handle the Response "created" event.
     *
     * @param  \App\Models\Response  $response
     * @return void
     */
    public function created(Response $response)
    {
        $user = User::find($response->complain->user_id);

        Notification::send($user, new ResponseUpdate($response));
    }

    /**
     * Handle the Response "updated" event.
     *
     * @param  \App\Models\Response  $response
     * @return void
     */
    public function updated(Response $response)
    {
        //
    }

    /**
     * Handle the Response "deleted" event.
     *
     * @param  \App\Models\Response  $response
     * @return void
     */
    public function deleted(Response $response)
    {
        //
    }

    /**
     * Handle the Response "restored" event.
     *
     * @param  \App\Models\Response  $response
     * @return void
     */
    public function restored(Response $response)
    {
        //
    }

    /**
     * Handle the Response "force deleted" event.
     *
     * @param  \App\Models\Response  $response
     * @return void
     */
    public function forceDeleted(Response $response)
    {
        //
    }
}
