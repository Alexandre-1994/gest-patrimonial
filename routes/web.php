<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\PhysicalInventoryController;
use App\Http\Controllers\AssetMovementController;
use App\Http\Controllers\UserController;




Route::get('/', function () {
    return view('dashboard');
});
Route::resource('asset_movements', AssetMovementController::class);
Route::resource('ativos', AssetController::class);
Route::get('/', [AssetController::class, 'dashboard'])->name('dashboard');
Route::resource('physical_inventories', PhysicalInventoryController::class);
Route::resource('users', UserController::class);
