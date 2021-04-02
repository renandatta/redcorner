<?php

namespace App\Http\Controllers;

use App\Repositories\KategoriRepositories;
use App\Repositories\ProdukRepositories;
use App\Repositories\RuanganRepositories;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $kategori, $ruangan, $produk;
    public function __construct(KategoriRepositories $kategori,
                                RuanganRepositories $ruangan,
                                ProdukRepositories $produk)
    {
        $this->kategori = $kategori;
        $this->ruangan = $ruangan;
        $this->produk = $produk;
    }

    public function index()
    {
        $list_kategori = $this->kategori->dropdown(true);
        $ruangan = $this->ruangan->ruangan_utama();
        $produk = $this->produk->featured_produk();
        return view('home.index', compact('list_kategori', 'ruangan', 'produk'));
    }

    public function produk_quickview(Request $request)
    {
        $request->validate(['id' => 'required']);
        $produk = $this->produk->find($request->input('id'));
        return view('home._quickview', compact('produk'));
    }
}
