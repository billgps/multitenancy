<?php

use App\Http\Controllers\API\InventoryAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::domain(app('currentTenant')->domain)->group(function() {
    Route::prefix('inventory')->group(function () {
        Route::get('/', [InventoryAPIController::class, 'index'])->name('api.inventory.index'); 
        Route::get('/{inventory}', [InventoryAPIController::class, 'show'])->name('api.inventory.show'); 
    });
    Route::get('/search/{barcode}', [InventoryAPIController::class, 'scan'])->name('api.barcode');
});
