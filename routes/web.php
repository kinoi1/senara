<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaketController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\UserController;

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


Route::get('/', [AuthController::class, 'index'])->name('login.index');
Route::post('/login', [AuthController::class, 'login'])->name('dologin');

Route::get('/register', [AuthController::class, 'sigup'])->name('register.index');
Route::post('/doregister', [AuthController::class, 'register'])->name('doregister');

Route::prefix('dashboard')->middleware('checksession')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

});

Route::prefix('reseller')->middleware('checksession')->group(function () {
    Route::get('/', [ResellerController::class, 'index'])->name('reseller.index');
    Route::post('/save', [ResellerController::class, 'save'])->name('reseller.save');
    Route::get('/edit/{id}', [ResellerController::class, 'edit'])->name('reseller.edit');
    Route::delete('/delete/{id}', [ResellerController::class, 'delete'])->name('reseller.delete');
});

Route::prefix('product')->middleware('checksession')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::post('/save', [ProductController::class,"save"]);
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
});

Route::prefix('user')->middleware('checksession')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::post('/save', [UserController::class,"save"]);
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
});

Route::prefix('category')->middleware('checksession')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/save', [CategoryController::class,"save"]);
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');
});

Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
Route::post('/paket/add-to-cart', [PaketController::class, 'addToCart']);
Route::get('/paket/GetListCart', [PaketController::class, 'GetListCart']);
Route::get('/test-image', function () {
    return response()->file(storage_path('app/public/gambar/cek.jpg'));
});

