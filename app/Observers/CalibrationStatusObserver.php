<?php

namespace App\Observers;

use App\Models\Record;
use App\Models\User;
use App\Notifications\CalibrationStatusUpdate;
use Illuminate\Support\Facades\Notification;

class CalibrationStatusObserver
{
    /**
     * Handle the Record "created" event.
     *
     * @param  \App\Models\Record  $record
     * @return void
     */
    public function created(Record $record)
    {
        //
    }

    /**
     * Handle the Record "updated" event.
     *
     * @param  \App\Models\Record  $record
     * @return void
     */
    public function updated(Record $record)
    {
        // $users = User::where('role', 1)->get();

        // Notification::send($users, new CalibrationStatusUpdate($record, ' membuat komplain baru'));
    }

    /**
     * Handle the Record "deleted" event.
     *
     * @param  \App\Models\Record  $record
     * @return void
     */
    public function deleted(Record $record)
    {
        //
    }

    /**
     * Handle the Record "restored" event.
     *
     * @param  \App\Models\Record  $record
     * @return void
     */
    public function restored(Record $record)
    {
        //
    }

    /**
     * Handle the Record "force deleted" event.
     *
     * @param  \App\Models\Record  $record
     * @return void
     */
    public function forceDeleted(Record $record)
    {
        //
    }
}
