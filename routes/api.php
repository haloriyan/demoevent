<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\HandbookController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('users/search', [UserController::class, 'search']);

Route::post('handbooks', [AdminController::class, 'handbook']);
Route::group(['middleware' => "Cors"], function () {
    Route::get('pdf/{filename}', [UserController::class, 'streamPdf']);
});

Route::group(['prefix' => "callback"], function () {
    Route::post('wa', [AdminController::class, 'callbackWa']);
});

Route::group(['prefix' => "v2"], function () {
    Route::post('home', [ContentController::class, 'home']);
    Route::post('preparation', [ContentController::class, 'preparation']);
    Route::post('store', [ContentController::class, 'store']);
});