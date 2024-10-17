<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResellerController;

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
    return view('index');
});

Route::get('/reseller', [ResellerController::class, 'index'])->name('reseller.index');
Route::post('/reseller/save', [ResellerController::class,"save"]);
Route::get('/reseller/edit/{id}', [ResellerController::class, 'edit'])->name('reseller.edit');
Route::delete('/reseller/delete/{id}', [ResellerController::class, 'delete'])->name('reseller.delete');


Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::post('/product/save', [ProductController::class,"save"]);
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');