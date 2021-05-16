<?php

namespace App\Http\Controllers;

use App\Repositories\PembayaranPinjamanRepositories;
use App\Repositories\PinjamanRepositories;
use App\Repositories\SimpananRepositories;
use App\Repositories\TransaksiRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NeracaController extends Controller
{
    protected $simpanan, $pinjaman, $pembayaran, $transaksi;
    public function __construct(SimpananRepositories $simpanan,
                                PinjamanRepositories $pinjaman,
                                PembayaranPinjamanRepositories $pembayaran,
                                TransaksiRepositories $transaksi)
    {
        $this->simpanan = $simpanan;
        $this->pinjaman = $pinjaman;
        $this->pembayaran = $pembayaran;
        $this->transaksi = $transaksi;
    }

    public function index()
    {
        return view('neraca.index');
    }

    public function search(Request $request)
    {
        $simpanan = $this->simpanan->search(new Request([
            'select' => array(DB::raw('sum(nominal) as total_nominal'))
        ]));
        $pinjaman = $this->pinjaman->search(new Request([
            'select' => array(DB::raw('sum(nominal) as total_nominal'))
        ]));
        $pembayaran = $this->pembayaran->search(new Request([
            'select' => array(DB::raw('sum(nominal) as total_nominal'))
        ]));
        $laba_transaksi = $this->transaksi->search(new Request([
            'status' => 'Selesai',
            'select' => array(DB::raw('sum(harga_produk-harga_beli) as total_nominal'))
        ]));
        $diskon_transaksi = $this->transaksi->search(new Request([
            'status' => 'Selesai',
            'select' => array(DB::raw('sum(diskon) as total_nominal'))
        ]));
        return view('neraca._table', compact(
            'simpanan', 'pinjaman', 'pembayaran', 'laba_transaksi', 'diskon_transaksi'
        ));
    }
}
