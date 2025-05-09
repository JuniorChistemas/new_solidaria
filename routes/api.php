<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Panel\GuideController;
use App\Http\Controllers\Panel\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/getinventory', [InventoryController::class, 'listInventory']);




Route::get('/guides', [GuideController::class, 'index'])->name('api.guides.index');
Route::post('/guides', [GuideController::class, 'store'])->name('api.guides.store');
Route::get('/guides/{guide}', [GuideController::class, 'show'])->name('api.guides.show');
Route::put('/guides/{guide}', [GuideController::class, 'update'])->name('api.guides.update');
Route::delete('/guides/{guide}', [GuideController::class, 'destroy'])->name('api.guides.destroy');

// pipeline routes
Route::post('/guides/pipeline', [GuideController::class, 'sendGuide'])->name('api.guides.pipeline');



Route::resource('sales', SaleController::class);
// pipeline sale
Route::post('/sales/pipeline', [SaleController::class, 'sendSale'])->name('api.sales.pipeline');
