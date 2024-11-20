<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\PhysicalInventoryController;
use App\Http\Controllers\AssetMovementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetCategoryController;

// Rota do Dashboard (página inicial)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rotas de recursos
Route::resource('assets', AssetController::class);
Route::resource('asset-categories', AssetCategoryController::class);
Route::resource('asset_movements', AssetMovementController::class);
Route::resource('physical_inventories', PhysicalInventoryController::class);
Route::resource('users', UserController::class);
