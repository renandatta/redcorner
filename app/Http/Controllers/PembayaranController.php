<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\PinjamanSaveRequest;
use App\Repositories\MemberRepositories;
use App\Repositories\PembayaranPinjamanRepositories;
use App\Repositories\PinjamanRepositories;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    protected $pinjaman, $pembayaranPinjaman;
    public function __construct(MemberRepositories $member,
                                PembayaranPinjamanRepositories $pembayaranPinjaman)
    {
        $this->middleware(['auth', 'user_role']);
        $this->pembayaranPinjaman = $pembayaranPinjaman;
        view()->share(['list_member' => $member->dropdown()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.pembayaran']);
        return view('pembayaran.index');
    }

    public function search(Request $request)
    {
        $pembayaran = $this->pembayaranPinjaman->search($request);
        return view('pembayaran._table', compact('pembayaran'));
    }

    public function cetak(Request $request)
    {
        $pembayaran = $this->pembayaranPinjaman->search($request);
        return view('pembayaran.cetak', compact('pembayaran'));
    }

}
