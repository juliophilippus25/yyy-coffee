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

// Categories
Route::group(['prefix' => '/categories'], function() {
    Route::get('', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/store-category', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/edit-category', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/update-category', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/delete-category', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.delete');
});

Route::group(['prefix' => '/users'], function() {
    Route::get('', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index');
    Route::post('/store-user', [App\Http\Controllers\UsersController::class, 'store'])->name('users.store');
    Route::delete('/delete-user', [App\Http\Controllers\UsersController::class, 'destroy'])->name('users.delete');
});