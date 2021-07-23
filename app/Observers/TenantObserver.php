<?php

namespace App\Observers;

use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class TenantObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    /**
     * Handle the Tenant "created" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function created(Tenant $tenant)
    {
        DB::statement('CREATE DATABASE '.$tenant->database);
        Artisan::call('tenants:artisan "migrate --database=tenant --seed" --tenant='.$tenant->id);
    }

    /**
     * Handle the Tenant "updated" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function updated(Tenant $tenant)
    {
        //
    }

    /**
     * Handle the Tenant "deleted" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function deleted(Tenant $tenant)
    {
        //
    }

    /**
     * Handle the Tenant "restored" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function restored(Tenant $tenant)
    {
        //
    }

    /**
     * Handle the Tenant "force deleted" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function forceDeleted(Tenant $tenant)
    {
        //
    }
}
