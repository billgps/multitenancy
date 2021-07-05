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
        $inventories = Inventory::with('latest_record')->has('latest_record')->get();
        $counter = 0;

        foreach ($inventories as $inventory) {
            $cal_date = strtotime($inventory->latest_record->cal_date);
            // $inventory->latest_record->vendor = 'McDonald Trump';
            // $inventory->latest_record->update();

            if (isset($inventory->latest_record)) {
                if (date('Y-m-d') > date('Y-m-d', strtotime('+9 months', $cal_date))) {
                    $inventory->latest_record->calibration_status = 'Segera Dikalibrasi';
                    $inventory->latest_record->update();
                    $counter++;
                }
            }
        }

        $users = User::where('role', 1)->get();

        Notification::send($users, new CalibrationStatusUpdate(' item inventory haru segera dikalibrasi', $counter));

        return 0;
    }
}
