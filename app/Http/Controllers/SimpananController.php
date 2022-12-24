<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\SimpananSaveRequest;
use App\Repositories\JenisSimpananRepositories;
use App\Repositories\MemberRepositories;
use App\Repositories\SimpananRepositories;
use Illuminate\Http\Request;

class SimpananController extends Controller
{
    protected $simpanan;
    public function __construct(SimpananRepositories $simpanan,
                                MemberRepositories $member,
                                JenisSimpananRepositories $jenisSimpanan)
    {
        $this->middleware(['auth', 'user_role']);
        $this->simpanan = $simpanan;
        view()->share(['list_member' => $member->dropdown()]);
        view()->share(['list_jenis_simpanan' => $jenisSimpanan->dropdown()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.simpanan']);
        return view('simpanan.index');
    }

    public function search(Request $request)
    {
        $simpanan = $this->simpanan->search($request);
        return view('simpanan._table', compact('simpanan'));
    }

    public function info(Request $request)
    {
        $simpanan = $this->simpanan->find($request->input('id'));
        $no_simpanan = !empty($simpanan) ? $simpanan->no_simpanan : $this->simpanan->auto_number();
        $member_id = $request->input('member_id') ?? '';
        return view('simpanan._info', compact('simpanan', 'no_simpanan', 'member_id'));
    }

    public function save(SimpananSaveRequest $request)
    {
        $simpanan = $this->simpanan->save($request);
        $simpanan->nomor_baru = $this->simpanan->auto_number();
        return $simpanan;
    }

    public function delete(DeleteRequest $request)
    {
        return $this->simpanan->delete($request->input('id'));
    }

    public function riwayat_anggota(Request $request)
    {
        $riwayat = $this->simpanan->search($request);
        return view('simpanan._riwayat', compact('riwayat'));
    }

    public function cetak(Request $request)
    {
        $simpanan = $this->simpanan->search($request);
        if (count($simpanan) == 0) return redirect()->route('admin.simpanan');

        $terakhir = \App\Models\Simpanan::where('member_id', $request->input('member_id'))
            ->where('jenis_simpanan_id', 4)
            ->orderBy('tanggal', 'desc')
            ->first();
        $diff = 0;
        $kurang_bayar = 0;
        if (!empty($terakhir)) {
            $date1 = strtotime($terakhir->tanggal);
            $data2 = strtotime(date('Y-m-d'));

            $year1 = date('Y', $date1);
            $year2 = date('Y', $data2);

            $month1 = date('m', $date1);
            $month2 = date('m', $data2);

            $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
            $kurang_bayar = $diff * $terakhir->nominal;
        }

        $terakhir2 = \App\Models\Simpanan::where('member_id', $request->input('member_id'))
            ->where('jenis_simpanan_id', 2)
            ->orderBy('tanggal', 'desc')
            ->first();
        $diff2 = 0;
        $kurang_bayar2 = 0;
        if (!empty($terakhir2)) {
            $date1 = strtotime($terakhir2->tanggal);
            $data2 = strtotime(date('Y-m-d'));

            $year1 = date('Y', $date1);
            $year2 = date('Y', $data2);

            $month1 = date('m', $date1);
            $month2 = date('m', $data2);

            $diff2 = (($year2 - $year1) * 12) + ($month2 - $month1);
            $kurang_bayar2 = $diff2 * $terakhir2->nominal;
        }

        return view('simpanan.cetak', compact('simpanan', 'diff', 'kurang_bayar', 'diff2', 'kurang_bayar2'));
    }
}
