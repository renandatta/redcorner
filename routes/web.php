<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin');
});

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user');
        Route::post('search', [UserController::class, 'search'])->name('admin.user.search');
        Route::post('info', [UserController::class, 'info'])->name('admin.user.info');
        Route::post('save', [UserController::class, 'save'])->name('admin.user.save');
        Route::post('delete', [UserController::class, 'delete'])->name('admin.user.delete');
    });
});
