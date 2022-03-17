<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use App\Models\Record;
use App\Models\User;
use App\Notifications\CalibrationStatusUpdate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Spatie\Multitenancy\Commands\Concerns\TenantAware;
use Spatie\Multitenancy\Models\Tenant;

class CalibrationUpdate extends Command
{
    use TenantAware;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calibration:update {--tenant=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update calibration status of records that are 9 months past latest calibration date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Tenant::all()->eachCurrent(function(Tenant $tenant) {
            // the passed tenant has been made current
            Tenant::current()->is($tenant); // returns true;

            $inventories = Inventory::with('latest_record')->has('latest_record')->get();
            $scheduled = 0;
            $expired = 0;
    
            foreach ($inventories as $inventory) {
                $cal_date = strtotime($inventory->latest_record->cal_date);
                if (isset($inventory->latest_record)) {
                    if (date('Y-m-d') >= date('Y-m-d', strtotime('+9 months', $cal_date))) {
                        $existing = Record::where('inventory_id', $inventory->id)->get();
                        if ($existing) {
                            foreach ($existing as $rec) {
                                $rec->calibration_status = 'Expired';
                                $rec->update();
                            }    
                        }
                        if (date('Y-m-d') >= date('Y-m-d', strtotime('+12 months', $cal_date))) {
                            if ($inventory->latest_record->calibration_status != 'Expired') {
                                $inventory->latest_record->calibration_status = 'Expired';
                                $inventory->latest_record->update();
                                $expired++;
                            }
                        } else {
                            if ($inventory->latest_record->calibration_status != 'Segera Dikalibrasi') {
                                $inventory->latest_record->calibration_status = 'Segera Dikalibrasi';
                                $inventory->latest_record->update();
                                $scheduled++;
                            }
                        }
                    }
                }
            }
    
            $users = User::all();
    
            if ($scheduled > 0) {
                // foreach ($users as $user) {
                //     $user->notify(new CalibrationStatusUpdate("Wajib Kalibrasi", $scheduled));
                // }

                Notification::send($users, new CalibrationStatusUpdate("Wajib Kalibrasi", $scheduled));
            }
    
            if ($expired > 0) {
                // foreach ($users as $user) {
                //     $user->notify(new CalibrationStatusUpdate("Expired", $expired));
                // }

                Notification::send($users, new CalibrationStatusUpdate("Expired", $scheduled));
            }
        });

        return 0;
    }
}
