<?php

namespace App\Http\Controllers;

use App\Models\JenisSimpanan;
use App\Models\Simpanan;
use App\Repositories\PembayaranPinjamanRepositories;
use App\Repositories\PinjamanRepositories;
use App\Repositories\SimpananRepositories;
use App\Repositories\TransaksiRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    protected $simpanan, $pinjaman, $pembayaran, $transaksi;
    public function __construct(SimpananRepositories $simpanan,
                                PinjamanRepositories $pinjaman,
                                PembayaranPinjamanRepositories $pembayaran,
                                TransaksiRepositories $transaksi)
    {
        $this->middleware(['auth', 'user_role']);
        $this->simpanan = $simpanan;
        $this->pinjaman = $pinjaman;
        $this->pembayaran = $pembayaran;
        $this->transaksi = $transaksi;
    }

    public function index(Request $request)
    {
        session((['menu_active' => 'admin']));

        $tanggal_awal = unformat_date($request->input('tanggal_awal') ?? date('01-m-Y'));
        $tanggal_akhir = unformat_date($request->input('tanggal_akhir') ?? date('t-m-Y'));

        $simpanan = $this->simpanan->search(new Request([
            'select' => array(DB::raw('sum(nominal) as total_nominal')),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]));
        $pinjaman = $this->pinjaman->search(new Request([
            'select' => array(DB::raw('sum(nominal) as total_nominal')),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]));
        $pembayaran = $this->pembayaran->search(new Request([
            'select' => array(DB::raw('sum(nominal) as total_nominal')),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]));
        $laba_transaksi = $this->transaksi->search(new Request([
            'status' => 'Selesai',
            'select' => array(DB::raw('sum(harga_produk-harga_beli) as total_nominal')),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]));
        $diskon_transaksi = $this->transaksi->search(new Request([
            'status' => 'Selesai',
            'select' => array(DB::raw('sum(diskon) as total_nominal')),
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
        ]));

        $jenis = JenisSimpanan::all();
        $result = array();
        foreach ($jenis as $value) {
            array_push($result, [
                'category' => $value->nama,
                'value' => Simpanan::where('jenis_simpanan_id', $value->id)
                    ->where('tanggal', '>=', $tanggal_awal)
                    ->where('tanggal', '<=', $tanggal_akhir)
                    ->sum('nominal')
            ]);
        }

        return view('admin.dashboard', compact(
            'simpanan', 'pinjaman', 'pembayaran', 'laba_transaksi', 'diskon_transaksi', 'result',
            'tanggal_awal','tanggal_akhir'
        ));
    }
}
