<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => "Construction"], function () {
    Route::get('expiring', [UserController::class, 'expiring']);
    Route::match(['get', 'post'], '{step?}', [UserController::class, 'index'])->name('index');
    Route::match(['get', 'post'], 'pembayaran/{id}', [UserController::class, 'pembayaran'])->name('pembayaran');
});

include __DIR__ . "/admin.php";
include __DIR__ . "/booth.php";