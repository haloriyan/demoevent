<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoothController;
use App\Http\Controllers\HandbookController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => "admin"], function () {
    Route::match(['get', 'post'], 'login', [AdminController::class, 'login'])->name('admin.login');

    Route::group(['middleware' => "Admin"], function () {
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::group(['prefix' => "peserta"], function () {
            Route::post('{id}/update', [AdminController::class, 'updatePeserta'])->name('admin.peserta.update');
            Route::get('/', [AdminController::class, 'peserta'])->name('admin.peserta');
        });

        Route::post('scan', [AdminController::class, 'scan'])->name('admin.scan');

        Route::group(['prefix' => "transaksi/{id}"], function () {
            Route::post('confirm', [TransactionController::class, 'confirmByAdmin'])->name('admin.transaction.confirm');
        });

        Route::group(['prefix' => "ticket"], function () {
            Route::group(['prefix' => "category"], function () {
                Route::post('store', [TicketController::class, 'storeCategory'])->name('admin.ticket.category.store');
                Route::post('{id}/update', [TicketController::class, 'updateCategory'])->name('admin.ticket.category.update');
                Route::get('{id}/delete', [TicketController::class, 'deleteCategory'])->name('admin.ticket.category.delete');
            });

            Route::post('store', [TicketController::class, 'store'])->name('admin.ticket.store');
            Route::post('{id}/update', [TicketController::class, 'update'])->name('admin.ticket.update');
            Route::get('{id}/delete', [TicketController::class, 'delete'])->name('admin.ticket.delete');
            Route::get('/', [AdminController::class, 'ticket'])->name('admin.ticket');
        });

        Route::group(['prefix' => "handbook"], function () {
            Route::group(['prefix' => "category"], function () {
                Route::post('{id}/update', [HandbookController::class, 'updateCategory'])->name('admin.handbook.category.update');
                Route::get('{id}/delete', [HandbookController::class, 'deleteCategory'])->name('admin.handbook.category.delete');
                Route::post('store', [HandbookController::class, 'storeCategory'])->name('admin.handbook.category.store');
            });

            Route::post('store', [HandbookController::class, 'store'])->name('admin.handbook.store');
            Route::get('{id}/delete', [HandbookController::class, 'delete'])->name('admin.handbook.delete');
            Route::get('/', [AdminController::class, 'handbook'])->name('admin.handbook');
        });

        Route::group(['prefix' => "booth"], function () {
            Route::post('store', [BoothController::class, 'store'])->name('admin.booth.store');
            Route::post('{id}/update', [BoothController::class, 'update'])->name('admin.booth.update');
            Route::get('{id}/delete', [BoothController::class, 'delete'])->name('admin.booth.delete');
            Route::get('/', [AdminController::class, 'booth'])->name('admin.booth');
        });

        Route::group(['prefix' => "admin"], function () {
            Route::post('store', [AdminController::class, 'store'])->name('admin.admins.store');
            Route::post('{id}/update', [AdminController::class, 'update'])->name('admin.admins.update');
            Route::get('{id}/delete', [AdminController::class, 'delete'])->name('admin.admins.delete');
        });

        Route::group(['prefix' => "settings"], function () {
            Route::match(['get', 'post'], 'email', [AdminController::class, 'emailSettings'])->name('admin.settings.email');
            Route::get('admin', [AdminController::class, 'admins'])->name('admin.settings.admin');
            Route::match(['get', 'post'], '/', [AdminController::class, 'generalSettings'])->name('admin.settings.general');
        });
    });
});