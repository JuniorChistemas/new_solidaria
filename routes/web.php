<?php

use App\Http\Controllers\ClientTypeController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\DoctorController;
use App\Http\Controllers\Panel\SupplierController;
use App\Http\Controllers\LaboratoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



# route group for panel
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('panel')->name('panel.')->group(function () {
        # module suppliers
        Route::resource('suppliers', SupplierController::class)->except('edit');
        # list suppliers
        Route::get('listar-suppliers',[SupplierController::class,'listarProveedor'])->name('suppliers.listar');    
        
        # module categories
        Route::resource('categories', CategoryController::class);
        # list categories
        Route::get('listar-categories',[CategoryController::class,'listarCategories'])->name('categories.listar');
        # module Doctors
        Route::resource('doctors', DoctorController::class)->except('edit');
        # list doctors
        Route::get('listar-doctors',[DoctorController::class,'listarDoctors'])->name('doctors.listar');    
        # module laboratories
        Route::resource('laboratories', LaboratoryController::class);
        # list laboratories
        Route::get('listar-laboratories',[LaboratoryController::class,'listarLaboratories'])->name('laboratories.listar');

        # module Client Types
        Route::resource('clientTypes', ClientTypeController::class);
        # list Client Types
        Route::get('listar-clientTypes',[ClientTypeController::class,'listarClientTypes'])->name('clientTypes.listar');
    });
});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
