<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesReturnController;


// React App Route (Catch-all for SPA)
Route::get('/react/{any?}', function () {
    return view('react');
})->where('any', '.*');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalSales = \App\Models\Sale::sum('total_amount');
    $revenue = \App\Models\Sale::sum('paid_amount');
    $customersCount = \App\Models\Customer::count();
    $productsCount = \App\Models\Product::count();
    $recentSales = \App\Models\Sale::with('customer')->latest()->take(5)->get();

    return view('dashboard', compact('totalSales', 'revenue', 'customersCount', 'productsCount', 'recentSales'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('adjustments', \App\Http\Controllers\AdjustmentController::class);
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);

    // POS Routes
    Route::get('/pos', [\App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/sale', [\App\Http\Controllers\PosController::class, 'store'])->name('pos.store');

    // Sales Routes
    Route::resource('sales', SaleController::class)->only(['index', 'show']);
    Route::get('sales/{sale}/receipt', [SaleController::class, 'receipt'])->name('sales.receipt');
    Route::resource('returns', SalesReturnController::class);
    Route::get('sales/{sale}/return', [SalesReturnController::class, 'create'])->name('sales.return');
});

require __DIR__ . '/auth.php';
