<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlamatUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisSimpananController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NeracaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\TransaksiController;
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

Route::get('/', [HomeController::class, 'index'])->name('/');
Route::get('kategori/{slug}', [HomeController::class, 'kategori'])->name('kategori');
//Route::get('sembako', [HomeController::class, 'sembako'])->name('sembako');
//Route::get('tumpeng', [HomeController::class, 'tumpeng'])->name('tumpeng');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('register', [AuthController::class, 'register_proses'])->name('register.proses');
Route::post('login', [AuthController::class, 'login_proses'])->name('login.proses');

Route::prefix('produk')->group(function () {
    Route::get('/', [HomeController::class, 'produk'])->name('produk');
    Route::get('{slug}', [HomeController::class, 'produk_detail'])->name('produk.detail');
    Route::post('quickview', [HomeController::class, 'produk_quickview'])->name('produk.quickview');
});

Route::prefix('wishlist')->middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'wishlist'])->name('wishlist');
    Route::post('save', [HomeController::class, 'wishlist_save'])->name('wishlist.save');
    Route::post('delete', [HomeController::class, 'wishlist_delete'])->name('wishlist.delete');
});

Route::prefix('alamat')->middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'alamat'])->name('alamat');
    Route::post('save', [HomeController::class, 'alamat_save'])->name('alamat.save');
});
Route::prefix('checkout')->middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'checkout'])->name('checkout');
    Route::post('/', [HomeController::class, 'checkout_save'])->name('checkout.save');
});
Route::prefix('transaksi')->middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'transaksi'])->name('transaksi');
    Route::get('{no_transaksi}', [HomeController::class, 'transaksi_detail'])->name('transaksi.detail');
    Route::post('save', [HomeController::class, 'transaksi_save'])->name('transaksi.save');
});


Route::prefix('cart')->middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'cart'])->name('cart');
    Route::post('count', [HomeController::class, 'cart_count'])->name('cart.count');
    Route::post('minimal', [HomeController::class, 'cart_minimal'])->name('cart.minimal');
    Route::post('save', [HomeController::class, 'cart_save'])->name('cart.save');
    Route::post('delete', [HomeController::class, 'cart_delete'])->name('cart.delete');
});

Route::prefix('ruangan')->group(function () {
    Route::get('/', [HomeController::class, 'ruangan'])->name('ruangan');
    Route::get('{slug}', [HomeController::class, 'ruangan_detail'])->name('ruangan.detail');
});

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'proses'])->name('admin.login.proses');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

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

    Route::prefix('ruangan')->group(function () {
        Route::get('/', [RuanganController::class, 'index'])->name('admin.ruangan');
        Route::post('search', [RuanganController::class, 'search'])->name('admin.ruangan.search');
        Route::post('info', [RuanganController::class, 'info'])->name('admin.ruangan.info');
        Route::post('save', [RuanganController::class, 'save'])->name('admin.ruangan.save');
        Route::post('delete', [RuanganController::class, 'delete'])->name('admin.ruangan.delete');
        Route::post('delete_gambar', [RuanganController::class, 'delete_gambar'])->name('admin.ruangan.delete_gambar');
    });

    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('admin.transaksi');
        Route::post('search', [TransaksiController::class, 'search'])->name('admin.transaksi.search');
        Route::post('info', [TransaksiController::class, 'info'])->name('admin.transaksi.info');
        Route::post('save', [TransaksiController::class, 'save'])->name('admin.transaksi.save');
    });

    Route::prefix('member')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('admin.member');
        Route::get('cetak/kartu', [MemberController::class, 'cetak_kartu'])->name('admin.member.cetak.kartu');
        Route::post('search', [MemberController::class, 'search'])->name('admin.member.search');
        Route::post('info', [MemberController::class, 'info'])->name('admin.member.info');
        Route::post('save', [MemberController::class, 'save'])->name('admin.member.save');
        Route::post('delete', [MemberController::class, 'delete'])->name('admin.member.delete');
    });

    Route::prefix('jenis_simpanan')->group(function () {
        Route::get('/', [JenisSimpananController::class, 'index'])->name('admin.jenis_simpanan');
        Route::post('search', [JenisSimpananController::class, 'search'])->name('admin.jenis_simpanan.search');
        Route::post('info', [JenisSimpananController::class, 'info'])->name('admin.jenis_simpanan.info');
        Route::post('save', [JenisSimpananController::class, 'save'])->name('admin.jenis_simpanan.save');
        Route::post('delete', [JenisSimpananController::class, 'delete'])->name('admin.jenis_simpanan.delete');
    });

    Route::prefix('simpanan')->group(function () {
        Route::get('/', [SimpananController::class, 'index'])->name('admin.simpanan');
        Route::post('search', [SimpananController::class, 'search'])->name('admin.simpanan.search');
        Route::post('info', [SimpananController::class, 'info'])->name('admin.simpanan.info');
        Route::post('save', [SimpananController::class, 'save'])->name('admin.simpanan.save');
        Route::post('delete', [SimpananController::class, 'delete'])->name('admin.simpanan.delete');

        Route::post('riwayat/anggota', [SimpananController::class, 'riwayat_anggota'])->name('admin.simpanan.riwayat.anggota');
        Route::get('cetak', [SimpananController::class, 'cetak'])->name('admin.simpanan.cetak');
    });

    Route::prefix('pinjaman')->group(function () {
        Route::get('/', [PinjamanController::class, 'index'])->name('admin.pinjaman');
        Route::post('search', [PinjamanController::class, 'search'])->name('admin.pinjaman.search');
        Route::post('info', [PinjamanController::class, 'info'])->name('admin.pinjaman.info');
        Route::post('save', [PinjamanController::class, 'save'])->name('admin.pinjaman.save');
        Route::post('delete', [PinjamanController::class, 'delete'])->name('admin.pinjaman.delete');

        Route::post('pembayaran', [PinjamanController::class, 'pembayaran'])->name('admin.pinjaman.pembayaran');
        Route::post('pembayaran/search', [PinjamanController::class, 'pembayaran_search'])->name('admin.pinjaman.pembayaran.search');
        Route::post('pembayaran/save', [PinjamanController::class, 'pembayaran_save'])->name('admin.pinjaman.pembayaran.save');
        Route::post('pembayaran/delete', [PinjamanController::class, 'pembayaran_delete'])->name('admin.pinjaman.pembayaran.delete');

        Route::get('cetak', [PinjamanController::class, 'cetak'])->name('admin.pinjaman.cetak');
        Route::get('cetak_pembayaran/{id}', [PinjamanController::class, 'cetak_pembayaran'])->name('admin.pinjaman.cetak_pembayaran');
    });

    Route::prefix('pembayaran')->group(function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('admin.pembayaran');
        Route::get('cetak', [PembayaranController::class, 'cetak'])->name('admin.pembayaran.cetak');
        Route::post('search', [PembayaranController::class, 'search'])->name('admin.pembayaran.search');
    });

    Route::prefix('neraca')->group(function () {
        Route::get('/', [NeracaController::class, 'index'])->name('admin.neraca');
        Route::post('search', [NeracaController::class, 'search'])->name('admin.neraca.search');
    });

    Route::prefix('kasir')->group(function () {
        Route::get('/', [App\Http\Controllers\KasirController::class, 'index'])->name('admin.kasir');
        Route::get('info', [App\Http\Controllers\KasirController::class, 'info'])->name('admin.kasir.info');
        Route::post('search', [App\Http\Controllers\KasirController::class, 'search'])->name('admin.kasir.search');
        Route::post('save', [App\Http\Controllers\KasirController::class, 'save'])->name('admin.kasir.save');
        Route::post('delete', [App\Http\Controllers\KasirController::class, 'delete'])->name('admin.kasir.delete');
        Route::post('search_item', [App\Http\Controllers\KasirController::class, 'search_item'])->name('admin.kasir.search_item');
        Route::post('save_item', [App\Http\Controllers\KasirController::class, 'save_item'])->name('admin.kasir.save_item');
        Route::post('delete_item', [App\Http\Controllers\KasirController::class, 'delete_item'])->name('admin.kasir.delete_item');

    });

    Route::get('tagihan', [NeracaController::class, 'tagihan'])->name('admin.tagihan');
});

Route::get('generate', function (\App\Repositories\SimpananRepositories $simpanan) {



//    $data = \App\Models\Simpanan::select('member_id', \Illuminate\Support\Facades\DB::raw('sum(nominal) as jumlah'))
//        ->where('jenis_simpanan_id', 4)
//        ->groupBy('member_id')
//        ->get();
//    foreach ($data as $value) {
//        \App\Models\Simpanan::create([
//            'member_id' => $value->member_id,
//            'jenis_simpanan_id' => 1,
//            'no_simpanan' => $simpanan->auto_number(),
//            'nominal' => $value->jumlah,
//            'tanggal' => date('Y-m-d')
//        ]);
//    }
});
