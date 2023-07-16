<?php

use App\Http\Controllers\{
	CheckoutController,
	OrderController,
	ShopController,
};
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

Route::get('/', [ShopController::class, 'index'])->name('shop');
Route::get('/order/{id}', [OrderController::class, 'index'])->name('order');

Route::post('/checkout', [CheckoutController::class, 'index'])->name('checkout');
