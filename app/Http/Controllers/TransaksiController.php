<?php

namespace App\Http\Controllers;

use App\Repositories\TransaksiRepositories;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    protected $transaksi;
    public function __construct(TransaksiRepositories $transaksi)
    {
        $this->middleware(['auth', 'user_role']);
        $this->transaksi = $transaksi;
        view()->share(['list_status' => $transaksi->list_status()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.transaksi']);
        return view('transaksi.index');
    }

    public function search(Request $request)
    {
        $transaksi = $this->transaksi->search($request);
        return view('transaksi._table', compact('transaksi'));
    }

    public function info(Request $request)
    {
        $transaksi = $this->transaksi->find($request->input('id'));
        return view('transaksi._info', compact('transaksi'));
    }

    public function save(Request $request)
    {
        return $this->transaksi->save($request);
    }
}
