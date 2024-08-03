<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Livewire\ItemImg;
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

Route::get('/', [ItemController::class, 'index'])->name('index');
Route::get('/item/search', [ItemController::class, 'search'])->name('search');
Route::get('/item/{item_id}', [ItemController::class, 'detail'])->name('item');
Route::get('/item/{item_id}/comment', [ItemController::class, 'comment'])->name('comment');

//ログイン認証
Route::middleware('auth')->group(function () {
    Route::get('/mypage', [AccountController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/profile', [AccountController::class, 'profile'])->name('mypage.profile');
    Route::post('/mypage/profile/update', [AccountController::class,'updateProfile'])->name('mypage.profile.update');
    Route::get('/sell', [ItemController::class, 'sell'])->name('sell');
    Route::get('/item-img', ItemImg::class)->name('item-img');
    Route::post('/sale', [ItemController::class, 'sale'])->name('sale');
    Route::post('/item/{item_id}/comment/create', [ItemController::class, 'createComment'])->name('comment.create');
    // 購入
    Route::get('/purchase/item/{item_id}', [PurchaseController::class, 'index'])->name('purchase');
    Route::get('/purchase/address', [PurchaseController::class, 'address'])->name('purchase.address');
    Route::post('/purchase/address/update', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');
    // 支払い方法
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/method', [PurchaseController::class, 'paymentMethod'])->name('method');
        Route::get('/method/select', [PurchaseController::class, 'paymentMethodSelection'])->name('method.select');
        Route::post('/stripe', [PurchaseController::class, 'stripe'])->name('stripe');
        Route::get('/success', [PurchaseController::class, 'paymentSuccess'])->name('success');
        Route::get('/failed', [PurchaseController::class, 'paymentFailed'])->name('failed');
    });

});
