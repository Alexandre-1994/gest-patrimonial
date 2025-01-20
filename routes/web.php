<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AssetController,
    PhysicalInventoryController,
    AssetMovementController,
    UserController,
    DashboardController,
    AssetCategoryController,
    AssetMaintenanceController,
    AssetDocumentController,
    CostCenterController
};

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/filter', [DashboardController::class, 'filterData'])->name('dashboard.filter');

// Ativos
Route::resource('assets', AssetController::class);
Route::controller(AssetController::class)->group(function () {
    Route::post('assets/store', 'store');
    Route::get('assets/export', 'export')->name('assets.export');
    Route::post('assets/import', 'import')->name('assets.import');
});

// Categorias
Route::resource('asset-categories', AssetCategoryController::class);

// Movimentações
// Route::resource('asset-movements', AssetMovementController::class);

// Inventário Físico
Route::resource('physical_inventories', PhysicalInventoryController::class);

// Usuários
Route::resource('users', UserController::class);

// Manutenções
Route::resource('asset-maintenances', AssetMaintenanceController::class);

// Documentos
Route::resource('asset-documents', AssetDocumentController::class);

// Centros de Custo
Route::resource('cost-centers', CostCenterController::class);

Route::resource('asset-movements', AssetMovementController::class);
Route::resource('asset-categories', AssetCategoryController::class);
Route::resource('cost-centers', CostCenterController::class);
// Route::get('/assets/by-category', [AssetController::class, 'byCategory'])->name('assets.by-category');
Route::get('assets-by-category', [AssetController::class, 'byCategory'])->name('assets.by-category');
Route::get('assets-value', [AssetController::class, 'totalValue'])->name('assets.value');
Route::get('assets-maintenance', [AssetController::class, 'inMaintenance'])->name('assets.maintenance');
Route::get('assets-depreciated', [AssetController::class, 'depreciated'])->name('assets.depreciated');
Route::get('assets-warranty', [AssetController::class, 'warranty'])->name('assets.warranty');
Route::get('/assets/next-code', [AssetController::class, 'getNextCode'])->name('assets.next-code');
Route::patch(
    '/asset-movements/{assetMovement}/approve',
    [AssetMovementController::class, 'approve']
)
    ->name('asset-movements.approve');

Route::patch(
    '/asset-movements/{assetMovement}/reject',
    [AssetMovementController::class, 'reject']
)
    ->name('asset-movements.reject');
