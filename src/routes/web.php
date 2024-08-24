<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\S3Controller;
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

if (app()->environment(['local'])) {
    $itemController = ItemController::class;
    $accountController = AccountController::class;
} else {
    $itemController = S3Controller::class;
    $accountController = S3Controller::class;
}

Route::get('/', [ItemController::class, 'index'])->name('index');
Route::get('/item/detail/{item_id}', [ItemController::class, 'detail'])->name('item');
Route::get('/item/search', [ItemController::class, 'search'])->name('search');
Route::get('/item/comment/{item_id}', [ItemController::class, 'comment'])->name('comment');

//ログイン認証
Route::middleware('auth')->group(function () use($accountController, $itemController) {
    Route::prefix('mypage')->name('mypage.')->group(function () use($accountController) {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
        Route::post('/profile', [$accountController,'updateProfile'])->name('profile.update');
    });
    Route::prefix('item')->group(function () use($itemController) {
        Route::get('/sell', [ItemController::class, 'sell'])->name('sell');
        Route::post('/sell', [$itemController, 'sale'])->name('sale');
        Route::post('/comment/{item_id}', [ItemController::class, 'createComment'])->name('comment.create');
        Route::post('/delete/comment/{item_id}', [ItemController::class, 'deleteComment'])->name('comment.delete');
    });
    // 購入
    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::get('/item/{item_id}', [PurchaseController::class, 'index'])->name('index');
        Route::get('/address', [PurchaseController::class, 'address'])->name('address');
        Route::post('/address', [PurchaseController::class, 'updateAddress'])->name('address.update');
    });
    // 支払い方法
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/method', [PurchaseController::class, 'paymentMethod'])->name('method');
        Route::get('/method/select', [PurchaseController::class, 'paymentMethodSelection'])->name('method.select');
        Route::post('/stripe', [PurchaseController::class, 'stripe'])->name('stripe');
        Route::get('/success', [PurchaseController::class, 'paymentSuccess'])->name('success');
        Route::get('/failed', [PurchaseController::class, 'paymentFailed'])->name('failed');
    });
});


//管理者用ルート
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/manage/user', [AdminController::class, 'getUsers'])->name('users');
    Route::post('/delete/user/{user_id}', [AdminController::class, 'deleteUser'])->name('delete.user');
    Route::get('/email', [AdminController::class, 'writeEmail'])->name('write.email');
    Route::post('/email', [AdminController::class, 'sendEmail'])->name('send.email');
});

