<?php

use Illuminate\Support\Facades\Route;
// 1. Import HomeController di bagian atas
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 2. Arahkan URL '/' ke method 'index' di dalam HomeController
Route::get('/', [HomeController::class, 'index']);
// 3. Arahkan URL '/cart' ke method 'index' di dalam CartController
Route::get('/cart', [CartController::class, 'index']);