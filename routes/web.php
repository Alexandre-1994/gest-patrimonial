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
Route::resource('asset-movements', AssetMovementController::class);

// Inventário Físico
Route::resource('physical-inventories', PhysicalInventoryController::class);

// Usuários
Route::resource('users', UserController::class);

// Manutenções
Route::resource('asset-maintenances', AssetMaintenanceController::class);

// Documentos
Route::resource('asset-documents', AssetDocumentController::class);

// Centros de Custo
Route::resource('cost-centers', CostCenterController::class);

Route::resource('asset-movements', AssetMovementController::class);
