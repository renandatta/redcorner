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
        view()->share(['list_kategori' => $kategori->dropdown(true)]);
    }

    public function index()
    {
        $ruangan = $this->ruangan->ruangan_utama();
        $produk = $this->produk->featured_produk();
        return view('home.index', compact('ruangan', 'produk'));
    }

    public function ruangan(Request $request)
    {
        $title = 'Meeting Room';
        $ruangan = $this->ruangan->search($request);
        return view('home.ruangan.index', compact('ruangan', 'title'));
    }

    public function ruangan_detail($slug)
    {
        $ruangan = $this->ruangan->find($slug, 'slug');
        if (empty($ruangan)) return abort(404);
        return view('home.ruangan.detail', compact('ruangan'));
    }

    public function sembako(Request $request)
    {
        $title = 'Sembako';
        $produk = $this->produk->sembako($request);
        return view('home.produk.index', compact('produk', 'title'));
    }

    public function tumpeng(Request $request)
    {
        $title = 'Tumpeng';
        $produk = $this->produk->tumpeng($request);
        return view('home.produk.index', compact('produk', 'title'));
    }

    public function produk(Request $request)
    {
        $title = 'Produk';
        $produk = $this->produk->produk($request);
        return view('home.produk.index', compact('produk', 'title'));
    }

    public function produk_detail($slug)
    {
        $produk = $this->produk->find($slug, 'slug');
        if (empty($produk)) return abort(404);
        $produk_terkait = $this->produk->search(new Request([
            'kategori_kode' => $produk->kategori->kode,
            'paginate' => 3,
            'id_not' => $produk->id
        ]));
        return view('home.produk.detail', compact('produk', 'produk_terkait'));
    }

    public function produk_quickview(Request $request)
    {
        $request->validate(['id' => 'required']);
        $produk = $this->produk->find($request->input('id'));
        return view('home.produk._quickview', compact('produk'));
    }
}
