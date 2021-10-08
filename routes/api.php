<?php

use App\Http\Controllers\API\InventoryAPIController;
use App\Http\Controllers\API\AssetAPIController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BrandAPIController;
use App\Http\Controllers\API\ConditionAPIController;
use App\Http\Controllers\API\DeviceAPIController;
use App\Http\Controllers\API\IdentityAPIController;
use App\Http\Controllers\API\MaintenanceAPIController;
use App\Http\Controllers\API\RecordAPIController;
use App\Http\Controllers\API\RoomAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;
use Spatie\Multitenancy\Models\Tenant;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

if (Tenant::current()) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::domain(Tenant::current()->domain)->middleware(['auth:sanctum'])->group(function() {
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.api.logout');
        Route::prefix('inventory')->group(function () {
            Route::get('/', [InventoryAPIController::class, 'index'])->name('api.inventory.index'); 
            Route::get('/{inventory}', [InventoryAPIController::class, 'show'])->name('api.inventory.show'); 
        });
        Route::prefix('asset')->group(function () {
            Route::get('/', [AssetAPIController::class, 'index'])->name('api.asset.index'); 
        });
        Route::prefix('consumable')->group(function () {
            Route::get('/', [ConsumableAPIController::class, 'index'])->name('api.consumable.index');
            Route::get('/{consumable}', [ConsumableAPIController::class, 'show'])->name('api.consumable.show');
        });
        Route::prefix('maintenance')->group(function () {
            Route::get('/', [MaintenanceAPIController::class, 'index'])->name('api.maintenance.index');
        });
        Route::prefix('record')->group(function () {
            Route::get('/', [RecordAPIController::class, 'index'])->name('api.record.index');
        });
        Route::prefix('condition')->group(function () {
            Route::get('/', [ConditionAPIController::class, 'index'])->name('api.condition.index');
            Route::get('/{condition}', [ConditionAPIController::class, 'show'])->name('api.condition.show');
        });
        Route::prefix('device')->group(function () {
            Route::get('/', [DeviceAPIController::class, 'index'])->name('api.device.index');
            Route::get('/{device}', [DeviceAPIController::class, 'show'])->name('api.device.show');
        });
        Route::prefix('room')->group(function () {
            Route::get('/', [RoomAPIController::class, 'index'])->name('api.room.index');
            Route::get('/{room}', [RoomAPIController::class, 'show'])->name('api.room.show');
        });
        Route::prefix('brand')->group(function () {
            Route::get('/', [BrandAPIController::class, 'index'])->name('api.brand.index');
            Route::get('/{brand}', [BrandAPIController::class, 'show'])->name('api.brand.show');
        });
        Route::prefix('identity')->group(function () {
            Route::get('/', [IdentityAPIController::class, 'index'])->name('api.identity.index');
        });
        Route::prefix('download')->group(function () {
            Route::get('/certificate/{record}', [RecordAPIController::class, 'certificateDownload']);
            Route::get('/report/{record}', [RecordAPIController::class, 'reportDownload']);
        });
        Route::get('/scan/{barcode}', [InventoryAPIController::class, 'scan'])->name('api.barcode');
    });
}
