<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\PinjamanSaveRequest;
use App\Repositories\MemberRepositories;
use App\Repositories\PembayaranPinjamanRepositories;
use App\Repositories\PinjamanRepositories;
use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    protected $pinjaman, $pembayaranPinjaman;
    public function __construct(PinjamanRepositories $pinjaman,
                                MemberRepositories $member,
                                PembayaranPinjamanRepositories $pembayaranPinjaman)
    {
        $this->middleware(['auth', 'user_role']);
        $this->pinjaman = $pinjaman;
        $this->pembayaranPinjaman = $pembayaranPinjaman;
        view()->share(['list_member' => $member->dropdown()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.pinjaman']);
        return view('pinjaman.index');
    }

    public function search(Request $request)
    {
        $pinjaman = $this->pinjaman->search($request);
        return view('pinjaman._table', compact('pinjaman'));
    }

    public function info(Request $request)
    {
        $pinjaman = $this->pinjaman->find($request->input('id'));
        $no_pinjaman = !empty($pinjaman) ? $pinjaman->no_pinjaman : $this->pinjaman->auto_number();
        $member_id = $request->input('member_id') ?? '';
        return view('pinjaman._info', compact('pinjaman', 'no_pinjaman', 'member_id'));
    }

    public function save(PinjamanSaveRequest $request)
    {
        return $this->pinjaman->save($request);
    }

    public function delete(DeleteRequest $request)
    {
        return $this->pinjaman->delete($request->input('id'));
    }

    public function pembayaran(Request $request)
    {
        $pinjaman_id = $request->input('pinjaman_id');
        $pinjaman = $this->pinjaman->find($pinjaman_id);
        $pembayaran = $this->pembayaranPinjaman->find($request->input('id'));
        $pembayaran_ke = !empty($pembayaran) ? $pembayaran->pinjaman_ke : $this->pembayaranPinjaman->auto_number($pinjaman_id);
        return view('pinjaman._pembayaran', compact(
            'pembayaran', 'pinjaman_id', 'pembayaran_ke', 'pinjaman'
        ));
    }

    public function pembayaran_search(Request $request)
    {
        $pembayaran = $this->pembayaranPinjaman->search($request);
        return view('pinjaman._pembayaran_table', compact('pembayaran'));
    }

    public function pembayaran_save(Request $request)
    {
        return $this->pembayaranPinjaman->save($request);
    }

    public function pembayaran_delete(Request $request)
    {
        return $this->pembayaranPinjaman->delete($request->input('id'));
    }

    public function cetak(Request $request)
    {
        $pinjaman = $this->pinjaman->search($request);

        return view('pinjaman.cetak', compact('pinjaman'));
    }

    public function cetak_pembayaran($id)
    {
        $pinjaman = $this->pinjaman->find($id);
        return view('pinjaman.laporan_pembayaran', compact('pinjaman'));
    }
}
