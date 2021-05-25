<?php

use App\Http\Controllers\TenantController;
use App\Http\Controllers\User\BrandController;
use App\Http\Controllers\User\DeviceController;
use App\Http\Controllers\User\IdentityController;
use App\Http\Controllers\User\RoomController;
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

if (Tenant::current()) {
    Route::domain(app('currentTenant')->domain)->middleware('tenant')->group(function() {
        Route::multiauth('User', 'user');
        Route::get('/', function () {
            return redirect()->route('user.dashboard');
        });
        Route::middleware(['auth:user'])->group(function () {
            Route::prefix('inventory')->group(function () {
                Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
                Route::get('/create', [InventoryController::class, 'create'])->name('inventory.create');
                Route::post('/store', [InventoryController::class, 'store'])->name('inventory.store');
                Route::post('/import', [InventoryController::class, 'import'])->name('inventory.import');
                Route::post('/image', [InventoryController::class, 'image'])->name('inventory.image');
                Route::get('/{id}', [InventoryController::class, 'show'])->name('inventory.show');
            });

            Route::prefix('device')->group(function () {
                Route::get('/', [DeviceController::class, 'index'])->name('device.index');
                Route::get('/create', [DeviceController::class, 'create'])->name('device.create');
                Route::post('/store', [DeviceController::class, 'store'])->name('device.store');
                Route::get('/{id}', [DeviceController::class, 'show'])->name('device.show');
                Route::get('/edit/{device}', [DeviceController::class, 'edit'])->name('device.edit');
                Route::post('/update/{device}', [DeviceController::class, 'update'])->name('device.update');
                Route::get('/delete/{device}', [DeviceController::class, 'destroy'])->name('device.delete');
            });

            Route::prefix('room')->group(function () {
                Route::get('/', [RoomController::class, 'index'])->name('room.index');
                Route::get('/create', [RoomController::class, 'create'])->name('room.create');
                Route::post('/store', [RoomController::class, 'store'])->name('room.store');
                Route::get('/{id}', [RoomController::class, 'show'])->name('room.show');
                Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('room.edit');
                Route::post('/update/{room}', [RoomController::class, 'update'])->name('room.update');
                Route::get('/delete/{room}', [RoomController::class, 'destroy'])->name('room.delete');
            });

            Route::prefix('brand')->group(function () {
                Route::get('/', [BrandController::class, 'index'])->name('brand.index');
                Route::get('/create', [BrandController::class, 'create'])->name('brand.create');
                Route::post('/store', [BrandController::class, 'store'])->name('brand.store');
                Route::get('/{id}', [BrandController::class, 'show'])->name('brand.show');
                Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('brand.edit');
                Route::post('/update/{brand}', [BrandController::class, 'update'])->name('brand.update');
                Route::get('/delete/{brand}', [BrandController::class, 'destroy'])->name('brand.delete');
            });

            Route::prefix('identity')->group(function () {
                Route::get('/', [IdentityController::class, 'index'])->name('identity.index');
                Route::get('/create', [IdentityController::class, 'create'])->name('identity.create');
                Route::post('/store', [IdentityController::class, 'store'])->name('identity.store');
                Route::get('/{id}', [IdentityController::class, 'show'])->name('identity.show');
                Route::get('/edit/{identity}', [IdentityController::class, 'edit'])->name('identity.edit');
                Route::post('/update/{identity}', [IdentityController::class, 'update'])->name('identity.update');
                Route::get('/delete/{identity}', [IdentityController::class, 'destroy'])->name('identity.delete');
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
