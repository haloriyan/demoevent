<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HandbookController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('handbooks', [AdminController::class, 'handbook']);
Route::group(['middleware' => "Cors"], function () {
    Route::get('pdf/{filename}', [UserController::class, 'streamPdf']);
});