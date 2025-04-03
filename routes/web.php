<?php

use App\Http\Controllers\Panel\SupplierController;
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
            Route::resource('suppliers', SupplierController::class);
        # list suppliers
            Route::get('listar-suppliers',[SupplierController::class,'listarProveedor'])->name('suppliers.listar');    


        
    });
});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
