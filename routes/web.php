<?php

use App\Http\Controllers\RamayanaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], 'tes', function (Request $request) {
    if ($request->method() == "GET") {
        return view('del');
    } else {
        $file = $request->file('berkas');
        return $file->getClientOriginalName();
    }
})->name('del');
Route::group(['middleware' => "Construction"], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('program', [UserController::class, 'program'])->name('program');
    Route::get('submission/{type?}', [UserController::class, 'submission'])->name('submission');
    Route::post('submission', [UserController::class, 'submissionSubmit'])->name('submission.submit');
    Route::get('e-poster', [UserController::class, 'eposter'])->name('eposter');
    Route::get('hubungi-kami', [UserController::class, 'contact'])->name('contact');
    Route::get('expiring', [UserController::class, 'expiring']);
    Route::match(['get', 'post'], '/register/{step?}', [UserController::class, 'register'])->name('register');
    Route::match(['get', 'post'], 'pembayaran/{id}', [UserController::class, 'pembayaran'])->name('pembayaran');
    Route::match(['get', 'post'], 'pembayaran-instan/{id}', [UserController::class, 'pembayaranInstan'])->name('pembayaran.instan');
    Route::group(['prefix' => "ramayana"], function () {
        Route::post('purchase', [RamayanaController::class, 'purchase'])->name('ramayana.purchase');
        Route::get('/', [UserController::class, 'ramayana'])->name('ramayana');
    });
});

include __DIR__ . "/admin.php";
include __DIR__ . "/booth.php";
include __DIR__ . "/xendit.php";