<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('assets/{folder}/{filename}', function ($folder,$filename){
    $path = storage_path('app/' . $folder . '/' . $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

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

    Route::prefix('kategori')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('admin.kategori');
        Route::post('search', [KategoriController::class, 'search'])->name('admin.kategori.search');
        Route::post('info', [KategoriController::class, 'info'])->name('admin.kategori.info');
        Route::post('save', [KategoriController::class, 'save'])->name('admin.kategori.save');
        Route::post('delete', [KategoriController::class, 'delete'])->name('admin.kategori.delete');
    });

    Route::prefix('produk')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('admin.produk');
        Route::post('search', [ProdukController::class, 'search'])->name('admin.produk.search');
        Route::post('info', [ProdukController::class, 'info'])->name('admin.produk.info');
        Route::post('save', [ProdukController::class, 'save'])->name('admin.produk.save');
        Route::post('delete', [ProdukController::class, 'delete'])->name('admin.produk.delete');
        Route::post('delete_gambar', [ProdukController::class, 'delete_gambar'])->name('admin.produk.delete_gambar');
    });
});
