<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('expiring', [UserController::class, 'expiring']);
Route::match(['get', 'post'], '{step?}', [UserController::class, 'index'])->name('index');
Route::get('pembayaran/{id}', [UserController::class, 'pembayaran'])->name('pembayaran');

include __DIR__ . "/admin.php";
include __DIR__ . "/booth.php";