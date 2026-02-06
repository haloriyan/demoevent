<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => "xendit"], function () {
    Route::get('/', [UserController::class, 'xendit']);
});