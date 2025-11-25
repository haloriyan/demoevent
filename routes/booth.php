<?php

use App\Http\Controllers\BoothController;
use App\Http\Controllers\ScanController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => "booth"], function () {
    Route::match(['get', 'post'], 'login', [BoothController::class, 'login'])->name('booth.login');

    Route::group(['middleware' => "Booth"], function () {
        Route::get('logout', [BoothController::class, 'logout'])->name('booth.logout');
        Route::get('dashboard', [BoothController::class, 'dashboard'])->name('booth.dashboard');
        Route::get('scan', [BoothController::class, 'scan'])->name('booth.scan');
        Route::post('checkin', [BoothController::class, 'checkin'])->name('booth.scan.checkin');
        Route::get('profile', [BoothController::class, 'profile'])->name('booth.profile');
        Route::post('profile/{id}/update', [BoothController::class, 'update'])->name('booth.profile.update');
    });

    Route::group(['prefix' => "scan", 'middleware' => "Cors"], function () {
        Route::post('check', [ScanController::class, 'check'])->name('scan.check');
    });
});
