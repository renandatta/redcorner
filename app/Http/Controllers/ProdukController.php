<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\ProdukSaveRequest;
use App\Repositories\KategoriRepositories;
use App\Repositories\ProdukRepositories;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    protected $produk;
    public function __construct(ProdukRepositories $produk, KategoriRepositories $kategori)
    {
        $this->middleware(['auth', 'user_role']);
        $this->produk = $produk;
        view()->share(['list_kategori' => $kategori->dropdown()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.produk']);
        return view('produk.index');
    }

    public function search(Request $request)
    {
        $produk = $this->produk->search($request);
        return view('produk._table', compact('produk'));
    }

    public function info(Request $request)
    {
        $produk = $this->produk->find($request->input('id'));
        return view('produk._info', compact('produk'));
    }

    public function save(ProdukSaveRequest $request)
    {
        $filename = $this->save_file($request);
        if ($filename != '') $request->merge(['gambar' => $filename]);
        return $this->produk->save($request);
    }

    public function delete(DeleteRequest $request)
    {
        return $this->produk->delete($request->input('id'));
    }

    public function delete_gambar(Request $request)
    {
        $gambar = $this->produk->delete_gambar($request->input('id'));
        if (!empty($gambar)) $this->delete_file($gambar->file);
        return $gambar;
    }
}
