<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Multitenancy\Commands\Concerns\TenantAware;
use Spatie\Multitenancy\Models\Tenant;

class SynchronizeUserRole extends Command
{
    use TenantAware;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:synchronize {--tenant=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronizing current users roles with new laravel permission system';

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
            Tenant::current()->is($tenant); // returns true;
            $users = User::all();

            foreach ($users as $user) {
                if ($user->role == 0) {
                    $user->assignRole('admin');
                } 

                else if ($user->role == 1) {
                    $user->assignRole('staff');
                }

                else {
                    $user->assignRole('visit');
                }

                echo($user->id.' done');
            }
        });

        return 0;
    }
}
