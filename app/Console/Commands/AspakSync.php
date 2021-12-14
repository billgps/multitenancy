<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Multitenancy\Models\Tenant;

class AspakSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:aspak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync tenant inventory database that has been mapped and ready to aspak monitoring API';

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
        Tenant::all()->eachCurrent(function (Tenant $tenant) {
            Tenant::current()->is($tenant);
        });

        return 0;
    }
}
