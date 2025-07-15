<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('admin')->group(function () {
    Route::get('/products', function () {
        return view('dashboard.products.index');
    })->name('products');
});



Route::get('/products/tambah', function () {
    return view('dashboard.products.tambah');
})->name('products-tambah');

Route::get('/products/edit', function () {
    return view('dashboard.products.edit');
})->name('products-edit');

Route::get('/categories-products', function () {
    return view('dashboard.categories-products.index');
})->name('categories-products');

Route::get('/categories-products/tambah', function () {
    return view('dashboard.categories-products.tambah');
})->name('categories-products-tambah');


Route::get('/categories-products/edit', function () {
    return view('dashboard.categories-products.edit');
})->name('categories-products-edit');



require __DIR__.'/auth.php';
