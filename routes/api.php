<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/products', [ProductController::class, 'getAllProducts'])->name('products.index');
Route::resource('sales', SaleController::class)->only(['index', 'store', 'show', 'destroy'])->names('sales');
Route::put('/sales/{sale}/products', [SaleController::class, 'addProductForSale'])->name('sales.products.add');
