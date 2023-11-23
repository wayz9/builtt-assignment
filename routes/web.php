<?php

use App\Http\Controllers\Auth\LoginController;
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

Route::get('/', function () {
    return view('products.index');
});

Route::view('/cart', 'cart.index');

Route::get('/login', [LoginController::class, 'show'])
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('login');
