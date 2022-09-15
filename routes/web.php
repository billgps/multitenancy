<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\User\ActivityController;
use App\Http\Controllers\User\ASPAKController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\User\AssetController;
use App\Http\Controllers\User\BookletController;
use App\Http\Controllers\User\BrandController;
use App\Http\Controllers\User\ComplainController;
use App\Http\Controllers\User\ConditionController;
use App\Http\Controllers\User\ConsumableController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\DeviceController;
use App\Http\Controllers\User\IdentityController;
use App\Http\Controllers\User\RoomController;
use App\Http\Controllers\User\InventoryController;
use App\Http\Controllers\User\MaintenanceController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\RecordController;
use App\Http\Controllers\User\ResponseController;
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
    // dd(Tenant::current());
    Route::domain(app('currentTenant')->domain)->middleware('tenant', 'notifications')->group(function() {
        Route::multiauth('User', 'user');
        Route::get('/', function () {
            return redirect()->route('user.dashboard');
        });
        
        Route::middleware(['auth:user', 'notifications'])->group(function () {
            Route::middleware(['active'])->group(function () {
                Route::prefix('inventory')->group(function () {
                    Route::middleware('role:admin')->group(function () {
                        Route::get('/booklet', [BookletController::class, 'index'])->name('booklet.index');
                        Route::get('booklet/pdf/{offset}', [BookletController::class, 'generate'])->name('booklet.generate');
                        Route::get('booklet/pdf/{$text}',[
                            'uses' => 'BookletController@makeQrCode',
                            'as'   => 'qrcode'
                          ]);
                    });
                    
                    Route::middleware(['role:admin|staff'])->group(function () {
                        Route::get('/create', [InventoryController::class, 'create'])->name('inventory.create');
                        Route::post('/store', [InventoryController::class, 'store'])->name('inventory.store');
                        Route::post('/import', [InventoryController::class, 'import'])->name('inventory.import');
                        Route::post('/image', [InventoryController::class, 'image'])->name('inventory.image');
                        Route::get('/edit/{inventory}', [InventoryController::class, 'edit'])->name('inventory.edit');
                        Route::post('/update/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
                        Route::get('/export', [InventoryController::class, 'export'])->name('inventory.export');
                        Route::get('/raw', [InventoryController::class, 'raw'])->name('inventory.raw');
                        Route::get('/excel/{inventory}', [InventoryController::class, 'excel'])->name('inventory.excel');
                        Route::get('/delete/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.delete');
                    });
                    
                    Route::middleware(['role:admin|staff|visit'])->group(function () {
                        Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
                        Route::get('/{id}', [InventoryController::class, 'show'])->name('inventory.show');
                        Route::post('/search', [InventoryController::class, 'search'])->name('inventory.search');
                        Route::get('/sort/{parameter}/{value}', [InventoryController::class, 'paramIndex'])->name('inventory.param');
                    });
                });
    
                Route::prefix('record')->group(function () {
                    Route::get('/', [RecordController::class, 'index'])->name('record.index');
                    Route::get('/create/{inventory?}', [RecordController::class, 'create'])->name('record.create');
                    Route::get('/{param}', [RecordController::class, 'paramIndex'])->name('record.param');
                    Route::post('/store', [RecordController::class, 'store'])->name('record.store');
                    Route::post('/import', [RecordController::class, 'import'])->name('record.import');
                    Route::get('/export/raw', [RecordController::class, 'export'])->name('record.export');
                    Route::post('/upload/report', [RecordController::class, 'reportUpload'])->name('record.upload.report');
                    Route::get('/download/report/{record}', [RecordController::class, 'reportDownload'])->name('record.download.report');
                    Route::post('/upload/certificate', [RecordController::class, 'certificateUpload'])->name('record.upload.certificate');
                    Route::get('/download/certificate/{record}', [RecordController::class, 'certificateDownload'])->name('record.download.certificate');
                    Route::get('/edit/{record}', [RecordController::class, 'edit'])->name('record.edit');
                    Route::post('/update/{record}', [RecordController::class, 'update'])->name('record.update');
                    Route::get('/delete/{record}', [RecordController::class, 'destroy'])->name('record.delete');
                });
    
                Route::prefix('condition')->group(function () {
                    Route::get('/', [ConditionController::class, 'index'])->name('condition.index');
                    Route::get('/create/{inventory?}', [ConditionController::class, 'create'])->name('condition.create');
                    Route::get('/{condition}', [ConditionController::class, 'show'])->name('condition.show');
                    Route::get('/{param}', [ConditionController::class, 'parameterIndex'])->name('condition.param');
                    Route::post('/update/{condition}', [ConditionController::class, 'update'])->name('condition.update');
                    Route::post('/store', [ConditionController::class, 'store'])->name('condition.store');
                    Route::post('/import', [ConditionController::class, 'import'])->name('condition.import');
                    Route::post('/upload/worksheet', [ConditionController::class, 'worksheetUpload'])->name('condition.upload.worksheet');
                    Route::get('/download/worksheet/{condition}', [ConditionController::class, 'worksheetDownload'])->name('condition.download.worksheet');
                    Route::get('/edit/{condition}', [ConditionController::class, 'edit'])->name('condition.edit');
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
    
                Route::prefix('maintenance')->group(function () {
                    Route::get('/', [MaintenanceController::class, 'index'])->name('maintenance.index');
                    Route::get('/create/{inventory}', [MaintenanceController::class, 'create'])->name('maintenance.create');
                    Route::post('/store', [MaintenanceController::class, 'store'])->name('maintenance.store');
                    Route::post('/import', [MaintenanceController::class, 'import'])->name('maintenance.import');
                    Route::get('/form/{maintenance}', [MaintenanceController::class, 'pdf'])->name('maintenance.download');
                    Route::get('/edit/{maintenance}', [MaintenanceController::class, 'edit'])->name('maintenance.edit');
                    Route::post('/update/{maintenance}', [MaintenanceController::class, 'update'])->name('maintenance.update');
                    Route::get('/delete/{maintenance}', [MaintenanceController::class, 'destroy'])->name('maintenance.delete');
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

                // Route::prefix('aspak')->middleware(['aspak'])->group(function () {
                //     Route::get('/', [ASPAKController::class, 'index'])->name('aspak.map');
                //     Route::get('/create/{id}', [ASPAKController::class, 'create'])->name('aspak.create');
                //     Route::post('/store', [ASPAKController::class, 'store'])->name('aspak.store');
                //     // Route::post('/map/device/{device}', [ASPAKController::class, 'bulkMap'])->name('aspak.bulk');
                //     // Route::post('/map/inventory/{inventory}', [ASPAKController::class, 'singleMap'])->name('aspak.single');
                // });
            });

            Route::prefix('device')->group(function () {
                Route::get('/', [DeviceController::class, 'index'])->name('device.index');
                Route::get('/create', [DeviceController::class, 'create'])->name('device.create');
                Route::post('/store', [DeviceController::class, 'store'])->name('device.store');
                Route::post('/map', [DeviceController::class, 'mapped'])->name('device.map');
                Route::post('/import', [DeviceController::class, 'import'])->name('device.import');
                Route::get('/export', [DeviceController::class, 'export'])->name('device.export');
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
                Route::get('/export', [RoomController::class, 'export'])->name('room.export');
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
                Route::get('/export', [BrandController::class, 'export'])->name('brand.export');
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
                Route::get('/export', [IdentityController::class, 'export'])->name('identity.export');
                Route::get('/download/manual/{identity}', [IdentityController::class, 'manualDownload'])->name('identity.download.manual');
                Route::get('/download/procedure/{identity}', [IdentityController::class, 'procedureDownload'])->name('identity.download.procedure');
                Route::get('/edit/{identity}', [IdentityController::class, 'edit'])->name('identity.edit');
                Route::post('/update/{identity}', [IdentityController::class, 'update'])->name('identity.update');
                Route::get('/delete/{identity}', [IdentityController::class, 'destroy'])->name('identity.delete');
            });
            Route::get('complain/pdf', [ComplainController::class, 'pdf']);
            Route::prefix('complain')->group(function () {
                Route::get('/', [ComplainController::class, 'index'])->name('complain.index');
                Route::get('/create', [ComplainController::class, 'create'])->name('complain.create');
                Route::post('/store', [ComplainController::class, 'store'])->name('complain.store');
                Route::get('/{id}', [ComplainController::class, 'show'])->name('complain.show');
                Route::get('/edit/{complain}', [ComplainController::class, 'edit'])->name('complain.edit');
                Route::get('/delete/{complain}', [ComplainController::class, 'destroy'])->name('complain.delete');
                
            });

            Route::prefix('response')->group(function () {
                // Route::get('/', [ResponseController::class, 'index'])->name('response.index');
                Route::get('/create/{complain}', [ResponseController::class, 'create'])->name('response.create');
                Route::post('/store', [ResponseController::class, 'store'])->name('response.store');
                Route::get('/{response}', [ResponseController::class, 'show'])->name('response.show');
                Route::get('/edit/{response}', [ResponseController::class, 'edit'])->name('response.edit');
                Route::post('/update', [ResponseController::class, 'update'])->name('response.update');
                // Route::get('/delete/{response}', [ResponseController::class, 'destroy'])->name('response.delete');
            }); 

            Route::prefix('activity')->middleware(['role:admin', 'aspak'])->group(function () {
                Route::get('/', [ActivityController::class, 'index'])->name('activity.index');
                Route::get('/create/{inventory?}', [ActivityController::class, 'create'])->name('activity.create');
                Route::post('/store', [ActivityController::class, 'store'])->name('activity.store');
                Route::get('/edit/{activity}', [ActivityController::class, 'edit'])->name('activity.edit');
                Route::post('/update/{activity}', [ActivityController::class, 'update'])->name('activity.update');
                Route::get('/delete/{activity}', [ActivityController::class, 'destroy'])->name('activity.delete');
            });

            Route::prefix('ajax')->group(function () {
                Route::get('/identities', [IdentityController::class, 'ajax'])->name('identity.ajax');
                Route::get('/brands', [BrandController::class, 'ajax'])->name('brand.ajax');
                Route::get('/complaints', [ComplainController::class, 'ajax'])->name('complain.ajax');
                Route::get('/notifications', [NotificationController::class, 'ajax'])->name('notification.ajax');
                Route::get('/aspak/create/', [ASPAKController::class, 'store'])->middleware('active');
                // Route::get('/aspak-details/{id}', [ASPAKController::class, 'ajaxGetDetails'])->name('aspak.details');
                // Route::get('/aspak-map/{device}', [ASPAKController::class, 'ajaxMap'])->name('aspak.nomenclature');
                Route::get('/pie/{parameter}', [DashboardController::class, 'pieChart'])->name('dashboard.pie');
                Route::post('/keyword/{nomenclature}/store', [NomenclatureController::class, 'addKeyword']);
            });

            Route::get('/user/notfication-routing/{notification}', [NotificationController::class, 'routing'])->name('user.notification.routing');
        });
    });
}

else if (Tenant::current() == null) {
    Route::get('/', function () {
        return redirect()->route('administrator.dashboard');
    });
    Route::multiauth('Administrator', 'administrator');
    Route::middleware(['auth:administrator', 'notifications'])->group(function () {
        Route::prefix('tenant')->group(function () {
            Route::get('/create', [TenantController::class, 'create'])->name('tenant.create');
            Route::post('/store', [TenantController::class, 'store'])->name('tenant.store');
            Route::get('/{tenant}', [TenantController::class, 'show'])->name('tenant.show');
            Route::get('/delete/{tenant}', [TenantController::class, 'destroy'])->name('tenant.delete');
        }); 
        Route::prefix('vendor')->group(function () {
            Route::get('/', [VendorController::class, 'index'])->name('vendor.index');
            Route::get('/create', [VendorController::class, 'create'])->name('vendor.create');
            Route::post('/store', [VendorController::class, 'store'])->name('vendor.store');
            Route::post('/update/{vendor}', [VendorController::class, 'update'])->name('vendor.update');
            Route::get('/{vendor}', [VendorController::class, 'show'])->name('vendor.show');
            Route::get('/edit/{vendor}', [VendorController::class, 'edit'])->name('vendor.edit');
        }); 
        Route::prefix('nomenclature')->group(function () {
            Route::get('/', [NomenclatureController::class, 'index'])->name('nomenclature.index');
            Route::get('/create', [NomenclatureController::class, 'create'])->name('nomenclature.create');
            Route::post('/store', [NomenclatureController::class, 'store'])->name('nomenclature.store');
            Route::get('/edit/{nomenclature}', [NomenclatureController::class, 'edit'])->name('nomenclature.edit');
            Route::post('/update/{nomenclature}', [NomenclatureController::class, 'update'])->name('nomenclature.update');
        });
        Route::prefix('aspak')->group(function () {
            Route::get('/queue', [QueueController::class, 'index'])->name('queue.index');
            Route::post('/queue/retry', [QueueController::class, 'retry'])->name('queue.retry');
            Route::get('/queue/{queue}', [QueueController::class, 'show'])->name('queue.show');
            Route::post('/queue/send/', [QueueController::class, 'batch'])->name('queue.send');
            Route::get('/queue/{queue}/logs', [QueueController::class, 'logs'])->name('queue.logs');
            Route::get('/log', [LogController::class, 'index'])->name('log.index');
        });
        Route::prefix('ajax')->group(function () {
            Route::get('/notifications', [NotificationController::class, 'ajax'])->name('notification.ajax');
            Route::delete('/queue/delete/{queue}', [QueueController::class, 'destroy'])->name('queue.delete');
        });
        
    });
}
