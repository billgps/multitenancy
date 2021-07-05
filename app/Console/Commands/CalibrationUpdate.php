<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\Multitenancy\Models\Tenant;

class CalibrationUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calibration:update';

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
            print($tenant->domain);
        });

        return 'A OK';
    }
}
