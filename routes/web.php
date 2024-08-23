<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('statusCheck');
Route::get('/profile-user', [App\Http\Controllers\UsersController::class, 'profile'])->name('users.profile');
Route::put('/update-profile', [App\Http\Controllers\UsersController::class, 'update_profile'])->name('users.update-profile');

// Categories
Route::group(['prefix' => '/categories'], function() {
    Route::get('', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/store-category', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/edit-category', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/update-category', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/delete-category', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.delete');
});

// Payments
Route::group(['prefix' => '/payments'], function() {
    Route::get('', [App\Http\Controllers\PaymentController::class, 'index'])->name('payments.index');
    Route::post('/store-payment', [App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/edit-payment', [App\Http\Controllers\PaymentController::class, 'edit'])->name('payments.edit');
    Route::post('/update-payment', [App\Http\Controllers\PaymentController::class, 'update'])->name('payments.update');
    Route::delete('/delete-payment', [App\Http\Controllers\PaymentController::class, 'destroy'])->name('payments.delete');
});

// Products
Route::group(['prefix' => '/products'], function() {
    Route::get('', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::post('/store-product', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('/edit-product', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::get('/show-product', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
    Route::post('/update-product', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::delete('/delete-product', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.delete');
});

// Transactions
Route::group(['prefix' => '/transactions'], function() {
    Route::get('', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/store-transaction', [App\Http\Controllers\TransactionController::class, 'store'])->name('transactions.store');
    Route::delete('/delete-transaction', [App\Http\Controllers\TransactionController::class, 'destroy'])->name('transactions.delete');
});

// Users
Route::group(['prefix' => '/users'], function() {
    Route::get('', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index');
    Route::post('/store-user', [App\Http\Controllers\UsersController::class, 'store'])->name('users.store');
    Route::delete('/delete-user', [App\Http\Controllers\UsersController::class, 'destroy'])->name('users.delete');
    Route::post('/status-user', [App\Http\Controllers\UsersController::class, 'status'])->name('users.status');
});
