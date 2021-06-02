<?php

use App\Http\Controllers\TenantController;
use App\Http\Controllers\User\AssetController;
use App\Http\Controllers\User\BrandController;
use App\Http\Controllers\User\ConditionController;
use App\Http\Controllers\User\ConsumableController;
use App\Http\Controllers\User\DeviceController;
use App\Http\Controllers\User\IdentityController;
use App\Http\Controllers\User\RoomController;
use App\Http\Controllers\User\InventoryController;
use App\Http\Controllers\User\RecordController;
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
                Route::post('/import', [DeviceController::class, 'import'])->name('device.import');
                Route::get('/{id}', [DeviceController::class, 'show'])->name('device.show');
                Route::get('/edit/{device}', [DeviceController::class, 'edit'])->name('device.edit');
                Route::post('/update/{device}', [DeviceController::class, 'update'])->name('device.update');
                Route::get('/delete/{device}', [DeviceController::class, 'destroy'])->name('device.delete');
            });

            Route::prefix('room')->group(function () {
                Route::get('/', [RoomController::class, 'index'])->name('room.index');
                Route::get('/create', [RoomController::class, 'create'])->name('room.create');
                Route::post('/store', [RoomController::class, 'store'])->name('room.store');
                Route::post('/import', [RoomController::class, 'import'])->name('room.import');
                Route::get('/{id}', [RoomController::class, 'show'])->name('room.show');
                Route::get('/edit/{room}', [RoomController::class, 'edit'])->name('room.edit');
                Route::post('/update/{room}', [RoomController::class, 'update'])->name('room.update');
                Route::get('/delete/{room}', [RoomController::class, 'destroy'])->name('room.delete');
            });

            Route::prefix('brand')->group(function () {
                Route::get('/', [BrandController::class, 'index'])->name('brand.index');
                Route::get('/create', [BrandController::class, 'create'])->name('brand.create');
                Route::post('/store', [BrandController::class, 'store'])->name('brand.store');
                Route::post('/import', [BrandController::class, 'import'])->name('brand.import');
                Route::get('/{id}', [BrandController::class, 'show'])->name('brand.show');
                Route::get('/edit/{brand}', [BrandController::class, 'edit'])->name('brand.edit');
                Route::post('/update/{brand}', [BrandController::class, 'update'])->name('brand.update');
                Route::get('/delete/{brand}', [BrandController::class, 'destroy'])->name('brand.delete');
            });

            Route::prefix('identity')->group(function () {
                Route::get('/', [IdentityController::class, 'index'])->name('identity.index');
                Route::get('/create', [IdentityController::class, 'create'])->name('identity.create');
                Route::post('/store', [IdentityController::class, 'store'])->name('identity.store');
                Route::post('/import', [IdentityController::class, 'import'])->name('identity.import');
                // Route::get('/{id}', [IdentityController::class, 'show'])->name('identity.show');
                Route::get('/edit/{identity}', [IdentityController::class, 'edit'])->name('identity.edit');
                Route::post('/update/{identity}', [IdentityController::class, 'update'])->name('identity.update');
                Route::get('/delete/{identity}', [IdentityController::class, 'destroy'])->name('identity.delete');
            });

            Route::prefix('asset')->group(function () {
                Route::get('/', [AssetController::class, 'index'])->name('asset.index');
                Route::get('/create/{inventory?}', [AssetController::class, 'create'])->name('asset.create');
                Route::post('/store', [AssetController::class, 'store'])->name('asset.store');
                Route::post('/import', [AssetController::class, 'import'])->name('asset.import');
                // Route::get('/{id}', [AssetController::class, 'show'])->name('asset.show');
                Route::get('/edit/{asset}', [AssetController::class, 'edit'])->name('asset.edit');
                Route::post('/update/{asset}', [AssetController::class, 'update'])->name('asset.update');
                Route::get('/delete/{asset}', [AssetController::class, 'destroy'])->name('asset.delete');
            });

            Route::prefix('record')->group(function () {
                Route::get('/', [RecordController::class, 'index'])->name('record.index');
                Route::get('/create/{inventory?}', [RecordController::class, 'create'])->name('record.create');
                Route::post('/store', [RecordController::class, 'store'])->name('record.store');
                Route::post('/import', [RecordController::class, 'import'])->name('record.import');
                Route::post('/upload/report', [RecordController::class, 'reportUpload'])->name('record.upload.report');
                Route::post('/upload/certificate', [RecordController::class, 'certificateUpload'])->name('record.upload.certificate');
                Route::get('/download/report', [RecordController::class, 'reportDownload'])->name('record.download.report');
                Route::get('/download/certificate', [RecordController::class, 'certificateDownload'])->name('record.download.certificate');
                // Route::get('/{id}', [RecordController::class, 'show'])->name('record.show');
                Route::get('/edit/{record}', [RecordController::class, 'edit'])->name('record.edit');
                Route::post('/update/{record}', [RecordController::class, 'update'])->name('record.update');
                Route::get('/delete/{record}', [RecordController::class, 'destroy'])->name('record.delete');
            });

            Route::prefix('condition')->group(function () {
                Route::get('/', [ConditionController::class, 'index'])->name('condition.index');
                Route::get('/create/{inventory?}', [ConditionController::class, 'create'])->name('condition.create');
                Route::post('/store', [ConditionController::class, 'store'])->name('condition.store');
                Route::post('/import', [ConditionController::class, 'import'])->name('condition.import');
                Route::post('/upload/worksheet', [ConditionController::class, 'worksheetUpload'])->name('condition.upload.worksheet');
                Route::get('/download/worksheet', [ConditionController::class, 'worksheetDownload'])->name('condition.download.worksheet');
                Route::get('/{condition}', [ConditionController::class, 'show'])->name('condition.show');
                Route::get('/edit/{condition}', [ConditionController::class, 'edit'])->name('condition.edit');
                Route::post('/update/{condition}', [ConditionController::class, 'update'])->name('condition.update');
                Route::get('/delete/{condition}', [ConditionController::class, 'destroy'])->name('condition.delete');
            });

            Route::prefix('consumable')->group(function () {
                Route::get('/', [ConsumableController::class, 'index'])->name('consumable.index');
                Route::get('/create/{inventory?}', [ConsumableController::class, 'create'])->name('consumable.create');
                Route::post('/store', [ConsumableController::class, 'store'])->name('consumable.store');
                Route::post('/import', [ConsumableController::class, 'import'])->name('consumable.import');
                Route::get('/{consumable}', [ConsumableController::class, 'show'])->name('consumable.show');
                Route::get('/edit/{consumable}', [ConsumableController::class, 'edit'])->name('consumable.edit');
                Route::post('/update/{consumable}', [ConsumableController::class, 'update'])->name('consumable.update');
                Route::get('/delete/{consumable}', [ConsumableController::class, 'destroy'])->name('consumable.delete');
            });

            Route::prefix('ajax')->group(function () {
                Route::get('/identities', [IdentityController::class, 'ajax'])->name('identity.ajax');
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
