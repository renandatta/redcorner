<?php

namespace App\Http\Controllers;

use App\Models\PembayaranPinjaman;
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
        $pembayaran = $this->pembayaran->search(new Request([
            'select' => array(DB::raw('sum(nominal) as total_nominal'))
        ]));
        $bunga = 0;
        $temp = PembayaranPinjaman::with('pinjaman')->get();
        foreach ($temp as $value) {
            $bunga += $value->pinjaman->bunga_rupiah;
        }
        $laba_transaksi = $this->transaksi->search(new Request([
            'status' => 'Selesai',
            'select' => array(DB::raw('sum(harga_produk-harga_beli) as total_nominal'))
        ]));
        $diskon_transaksi = $this->transaksi->search(new Request([
            'status' => 'Selesai',
            'select' => array(DB::raw('sum(diskon) as total_nominal'))
        ]));
        return view('neraca._table', compact(
            'simpanan', 'pinjaman', 'pembayaran', 'laba_transaksi', 'diskon_transaksi', 'bunga'
        ));
    }

    public function tagihan()
    {
        $member = \App\Models\Member::all();
        $result = array();
        foreach ($member as $value) {
            $terakhir = \App\Models\Simpanan::where('member_id', $value->id)
                ->where('jenis_simpanan_id', 4)
                ->orderBy('tanggal', 'desc')
                ->first();
            if (!empty($terakhir)) {
                $date1 = strtotime($terakhir->tanggal);
                $data2 = strtotime(date('Y-m-d'));

                $year1 = date('Y', $date1);
                $year2 = date('Y', $data2);

                $month1 = date('m', $date1);
                $month2 = date('m', $data2);

                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
                $kurang_bayar = $diff * $terakhir->nominal;

                $value->terakhir = $terakhir;
                $value->durasi = $diff;
                $value->tagihan = $kurang_bayar;
                array_push($result, $value);
            }
        }
        return view('tagihan', compact('result'));
    }
}
