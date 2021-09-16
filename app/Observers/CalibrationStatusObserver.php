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
        // if ($record->calibration_status != 'Expired') {
        //     # code...
        // }
        // $existing = Record::where('inventory_id', $record->inventory_id)->get();
        // if ($existing) {
        //     foreach ($existing as $rec) {
        //         // $temp = Record::find($rec->id);
        //         $rec->calibration_status = 'Expired';
        //         $rec->update();
        //     }    
        // }
    }

    /**
     * Handle the Record "updated" event.
     *
     * @param  \App\Models\Record  $record
     * @return void
     */
    public function updated(Record $record)
    {
        // $existing = Record::where('inventory_id', $record->inventory_id)->get();
        // if ($existing) {
        //     foreach ($existing as $rec) {
        //         // $temp = Record::find($rec->id);
        //         $rec->calibration_status = 'Expired';
        //         $rec->update();
        //     }    
        // }
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
