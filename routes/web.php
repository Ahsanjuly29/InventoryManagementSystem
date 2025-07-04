<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;


Route::get('/', fn() => redirect('/reports'));


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [ReportController::class, 'index']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('sales', SaleController::class)->only(['index', 'create', 'store']);

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('search/products/', [ProductController::class, 'search'])->name('products.search');
    Route::get('search/customers/', [CustomerController::class, 'search'])->name('customers.search');

    Route::get('/products/{id}', [ProductController::class, 'show']); // returns JSON
    Route::get('/customers/{id}', [CustomerController::class, 'show']); // returns JSON
});


require __DIR__ . '/auth.php';
