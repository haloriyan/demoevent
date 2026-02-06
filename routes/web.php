<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => "Construction"], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('program', [UserController::class, 'program'])->name('program');
    Route::get('e-poster', [UserController::class, 'eposter'])->name('eposter');
    Route::get('hubungi-kami', [UserController::class, 'contact'])->name('contact');
    Route::get('expiring', [UserController::class, 'expiring']);
    Route::match(['get', 'post'], '/register/{step?}', [UserController::class, 'register'])->name('register');
    Route::match(['get', 'post'], 'pembayaran/{id}', [UserController::class, 'pembayaran'])->name('pembayaran');
});

include __DIR__ . "/admin.php";
include __DIR__ . "/booth.php";
include __DIR__ . "/xendit.php";