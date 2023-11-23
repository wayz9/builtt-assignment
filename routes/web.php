<?php

use App\Http\Controllers\AuthController;
use App\Livewire\{Product, Cart};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Product\Index::class)
    ->name('products.index');

Route::get('/cart', Cart\Index::class)
    ->middleware('auth')
    ->name('cart.index');

Route::get('/login', [AuthController::class, 'show'])
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
