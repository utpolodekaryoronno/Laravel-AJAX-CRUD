<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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



// Route::get('/',[ProductController::class,'products'])->name('products');
// Route::post('/add-product',[ProductController::class,'addProduct'])->name('add.product');
// Route::post('/update-product',[ProductController::class,'updateProduct'])->name('update.product');
// Route::get('product/{id}', [ProductController::class, 'show'])->name('product.show');
// Route::post('/delete-product',[ProductController::class,'deleteProduct'])->name('delete.product');
// Route::get('/pagination/paginate-data',[ProductController::class,'pagination']);
// Route::get('/product-search',[ProductController::class,'productSearch'])->name('product.search');




// Product Controller

Route::controller(ProductController::class)->group(function(){
    Route::get('/','products')->name('products');
    Route::post('/add-product','addProduct')->name('add.product');
    Route::put('/update-product','updateProduct')->name('update.product');
    Route::get('product/{id}', 'show')->name('product.show');
    Route::delete('/delete-product','deleteProduct')->name('delete.product');
    Route::get('/pagination/paginate-data','pagination');
    Route::get('/product-search','productSearch')->name('product.search');
});



