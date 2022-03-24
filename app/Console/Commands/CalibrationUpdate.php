<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use App\Models\Record;
use App\Models\User;
use App\Notifications\CalibrationStatusUpdate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Spatie\Multitenancy\Commands\Concerns\TenantAware;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\Log as FacadesLog;

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
        Tenant::whereDate('processed_at', '<', date('Y-m-d', strtotime('-1day', strtotime(date('Y-m-d')))))->take(5)->get()->eachCurrent(function(Tenant $tenant) {
            // the passed tenant has been made current
            Tenant::current()->is($tenant); // returns true;
            if (date('Y-m-d', strtotime('+1day', strtotime(Tenant::current()->processed_at))) < date('Y-m-d') ) {
                var_dump("tenant being worked on at a time : ".$tenant->id);
                $inventories = Inventory::with('latest_record')->has('latest_record')->get();
                $scheduled = 0;
                $expired = 0;

                try {
                    foreach ($inventories as $inventory) {
                        $cal_date = strtotime($inventory->latest_record->cal_date);
                        if (isset($inventory->latest_record)) {
                            $existing = Record::where('inventory_id', $inventory->id)
                                    ->whereDate('cal_date', '<', date('Y-m-d', $cal_date))
                                    ->get();
    
                            if ($existing->count() > 0) {
                                foreach ($existing as $rec) {
                                    $rec->calibration_status = "Expired";
                                    $rec->update();
                                }    
                            }
    
                            if (date('Y-m-d') >= date('Y-m-d', strtotime('+12 months', $cal_date))) {
                                DB::connection("tenant")->update('UPDATE '.$tenant->database.'.inventories
                                                                SET `is_verified` = 0 WHERE `id` = '.$inventory->id);
                                
                                if ($inventory->latest_record->calibration_status != "Expired") {
                                    $inventory->latest_record->calibration_status = "Expired";
                                    $inventory->latest_record->update();
                                    $expired++;
                                }
                            } 
                            else if (date('Y-m-d') >= date('Y-m-d', strtotime('+9 months', $cal_date))) {
                                if ($inventory->latest_record->calibration_status != "Segera Dikalibrasi") {
                                    $inventory->latest_record->calibration_status = "Segera Dikalibrasi";
                                    $inventory->latest_record->update();
                                    $scheduled++;
                                }
                            }
                            else {
                                if ($inventory->latest_record->calibration_status != "Terkalibrasi") {
                                    $inventory->latest_record->calibration_status = "Terkalibrasi";
                                    $inventory->latest_record->update();
                                }
                            }
                        }
                    }
            
                    $users = User::all();
            
                    if ($scheduled > 0) {
                        Notification::send($users, new CalibrationStatusUpdate("Wajib Kalibrasi", $scheduled));
                    }
            
                    if ($expired > 0) {
                        Notification::send($users, new CalibrationStatusUpdate("Expired", $scheduled));
                    }

                    // dd(date('Y-m-d h:i:s'));

                    DB::connection('host')->update('UPDATE `tenants` SET `processed_at` = "'.
                                    date('Y-m-d H:i:s').'" WHERE `id` = '.$tenant->id);
                } catch (\Throwable $th) {
                    FacadesLog::error($th);
                }
            }
        });
        
        return 0;
    }
}
