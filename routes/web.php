<?php

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

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

// Categories
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
Route::get('/fetchall', [App\Http\Controllers\CategoryController::class, 'fetchAll'])->name('fetchAll');
Route::post('/store-category', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
Route::get('/edit-category', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
Route::post('/update-category', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
Route::delete('/delete-category', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.delete');
