<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return 'Ini Route Utama';
});
// Route::get('/products', function () {
//     return 'Ini Route products';
// });
Route::get('/cart', function () {
    return 'Ini Route cart';
});
Route::get('/checkout', function () {
    return 'Ini Route checkout';
});

Route::resource('products',ProductController::class);