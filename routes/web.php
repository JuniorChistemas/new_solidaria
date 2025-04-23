<?php

use App\Http\Controllers\ClientTypeController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\ZoneController;
use App\Http\Controllers\Panel\DoctorController;
use App\Http\Controllers\Panel\SupplierController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\Panel\LocalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Inputs\SelectController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\Panel\GuideController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




# rutes no auth

Route::resource('guides',GuideController::class);


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
        # module zones
        Route::resource('zones', ZoneController::class);
        # list zones
        Route::get('listar-zones',[ZoneController::class,'listarZones'])->name('zones.listar');  
        # module Client Types
        Route::resource('clientTypes', ClientTypeController::class);
        # list Client Types
        Route::get('listar-clientTypes',[ClientTypeController::class,'listarClientTypes'])->name('clientTypes.listar');
        # module locals
        Route::resource('locals', LocalController::class);
        # list locals
         Route::get('listar-locals',[LocalController::class,'listarLocals'])->name('locals.listar');  
        # module Products
        Route::resource('products', ProductController::class); 
        # list Products
        Route::get('listar-products',[ProductController::class,'listarProducts'])->name('products.listar');
        # module Movements
        Route::resource('movements', MovementController::class); 
        # list Movements
        Route::get('listar-movements',[MovementController::class,'listMovements'])->name('movements.listar');
      
      
                # Route group for inputs, selects and autocomplete
                Route::prefix('inputs')->name('inputs.')->group(function(){
                    # get laboratory list
                    Route::get('laboratory_list',[SelectController::class,'getLaboratoryList'])->name('laboratory_list');
                    Route::get('category_list',[SelectController::class,'getCategoryList'])->name('category_list');

                    Route::get('suppliers', [SelectController::class, 'getSuppliers'])->name('suppliers_list');
                    Route::get('users', [SelectController::class, 'getUsers'])->name('users_list');
                    Route::get('movement-types', [SelectController::class, 'getMovementTypes'])->name('movement-types_list');
                    
                });
    });
});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
