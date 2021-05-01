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
        return view('simpanan.cetak', compact('simpanan'));
    }
}
