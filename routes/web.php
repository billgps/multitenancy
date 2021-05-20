<?php

use App\Http\Controllers\TenantController;
use App\Http\Controllers\User\InventoryController;
use Illuminate\Support\Facades\Route;
use Spatie\Multitenancy\Models\Tenant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
dd(Tenant::current());
if (Tenant::current()) {
    Route::domain(app('currentTenant')->domain.'.gps-inventory.com')->middleware('tenant')->group(function() {
        Route::multiauth('User', 'user');
        Route::get('/', function () {
            return redirect()->route('user.dashboard');
        });
        Route::middleware(['auth:user'])->group(function () {
            Route::prefix('inventory')->group(function () {
                Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
                Route::get('/create', [InventoryController::class, 'create'])->name('inventory.create');
                Route::post('/store', [InventoryController::class, 'store'])->name('inventory.store');
                Route::get('/{$id}', [InventoryController::class, 'show'])->name('inventory.show');
            });
        });
    });
} else {
    Route::get('/', function () {
        return redirect()->route('administrator.dashboard');
    });
    Route::multiauth('Administrator', 'administrator');
    Route::middleware(['auth:administrator'])->group(function () {
        Route::prefix('tenant')->group(function () {
            Route::get('/create', [TenantController::class, 'create'])->name('tenant.create');
            Route::post('/store', [TenantController::class, 'store'])->name('tenant.store');
            Route::get('/{tenant}', [TenantController::class, 'show'])->name('tenant.show');
        }); 
    });
}
