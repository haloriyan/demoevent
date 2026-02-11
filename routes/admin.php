<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BoothController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\HandbookController;
use App\Http\Controllers\RundownController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => "fo"], function () {
    Route::get('home', [AdminController::class, 'foHome'])->name('fo.home');
});

Route::group(['prefix' => "admin"], function () {
    Route::match(['get', 'post'], 'login', [AdminController::class, 'login'])->name('admin.login');
    Route::group(['middleware' => "Cors"], function () {
        Route::post('scan', [AdminController::class, 'scan'])->name('admin.scan');
    });

    Route::group(['middleware' => "Admin"], function () {
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::group(['prefix' => "peserta"], function () {
            Route::post('{id}/update', [AdminController::class, 'updatePeserta'])->name('admin.peserta.update');
            Route::get('/', [AdminController::class, 'peserta'])->name('admin.peserta');
        });

        Route::group(['prefix' => "speaker"], function () {
            Route::post('store', [SpeakerController::class, 'store'])->name('admin.speaker.store');
            Route::post('{id}/update', [SpeakerController::class, 'update'])->name('admin.speaker.update');
            Route::get('{id}/delete', [SpeakerController::class, 'delete'])->name('admin.speaker.delete');
            Route::get('/', [AdminController::class, 'speaker'])->name('admin.speaker');
        });
        Route::group(['prefix' => "schedule"], function () {
            Route::post('store', [ScheduleController::class, 'store'])->name('admin.schedule.store');
            Route::post('{id}/update', [ScheduleController::class, 'update'])->name('admin.schedule.update');
            Route::get('{id}/delete', [ScheduleController::class, 'delete'])->name('admin.schedule.delete');
            Route::get('/', [AdminController::class, 'schedule'])->name('admin.schedule');
        });
        Route::group(['prefix' => "rundown"], function () {
            Route::post('{rundownID?}/speaker', [RundownController::class, 'addSpeaker'])->name('admin.rundown.addSpeaker');
            Route::get('{rundownID?}/speaker/{speakerID}/delete', [RundownController::class, 'deleteSpeaker'])->name('admin.rundown.deleteSpeaker');
            Route::post('{rundownID}/update', [RundownController::class, 'update'])->name('admin.rundown.update');
            Route::get('{rundownID}/delete', [RundownController::class, 'delete'])->name('admin.rundown.delete');
            Route::post('store', [RundownController::class, 'store'])->name('admin.rundown.store');
        });

        Route::group(['prefix' => "transaksi/{id}"], function () {
            Route::match(['get', 'post'], 'confirm', [TransactionController::class, 'confirmByAdmin'])->name('admin.transaction.confirm');
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

        Route::group(['prefix' => "check-in"], function () {
            Route::get('registrasi', [AdminController::class, 'registrasiCheckin'])->name('admin.checkin.registrasi');
            Route::get('booth', [AdminController::class, 'boothCheckin'])->name('admin.checkin.booth');
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
        Route::group(['prefix' => "workshop"], function () {
            Route::get('/', [AdminController::class, 'workshop'])->name('admin.workshop');
        });

        Route::group(['prefix' => "admin"], function () {
            Route::post('store', [AdminController::class, 'store'])->name('admin.admins.store');
            Route::post('{id}/update', [AdminController::class, 'update'])->name('admin.admins.update');
            Route::get('{id}/delete', [AdminController::class, 'delete'])->name('admin.admins.delete');
        });

        Route::group(['prefix' => "settings"], function () {
            Route::group(['prefix' => "whatsapp"], function () {
                Route::get('{id}/primary', [AdminController::class, 'setWhatsappPrimary'])->name('admin.settings.whatsapp.primary');
                Route::match(['get', 'post'], '{id}/remove', [AdminController::class, 'removeWhatsapp'])->name('admin.settings.whatsapp.remove');
                Route::match(['get', 'post'], '/', [AdminController::class, 'whatsappSettings'])->name('admin.settings.whatsapp');
            });
            Route::match(['get', 'post'], 'whatsapp', [AdminController::class, 'whatsappSettings'])->name('admin.settings.whatsapp');
            Route::match(['get', 'post'], 'email', [AdminController::class, 'emailSettings'])->name('admin.settings.email');
            Route::get('admin', [AdminController::class, 'admins'])->name('admin.settings.admin');
            Route::match(['get', 'post'], '/', [AdminController::class, 'generalSettings'])->name('admin.settings.general');
        });

        Route::group(['prefix' => "broadcast"], function () {
            Route::get('{id}/detail', [BroadcastController::class, 'detail'])->name('admin.broadcast.detail');
            Route::post('store', [BroadcastController::class, 'store'])->name('admin.broadcast.store');
            Route::get('/', [AdminController::class, 'broadcast'])->name('admin.broadcast');
        });

        Route::group(['prefix' => "export"], function () {
            // Route::get('peserta', [])
        });
    });
});