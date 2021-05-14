<?php

namespace App\Http\Controllers;

use App\Repositories\CartRepositories;
use App\Repositories\KategoriRepositories;
use App\Repositories\ProdukRepositories;
use App\Repositories\RuanganRepositories;
use App\Repositories\TransaksiRepositories;
use App\Repositories\UserRepositories;
use App\Repositories\WishlistRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $kategori, $ruangan, $produk, $wishlist, $cart, $user, $transaksi;
    public function __construct(KategoriRepositories $kategori,
                                RuanganRepositories $ruangan,
                                ProdukRepositories $produk,
                                WishlistRepositories $wishlist,
                                CartRepositories $cart,
                                UserRepositories $user,
                                TransaksiRepositories $transaksi)
    {
        $this->kategori = $kategori;
        $this->ruangan = $ruangan;
        $this->produk = $produk;
        $this->wishlist = $wishlist;
        $this->cart = $cart;
        $this->user = $user;
        $this->transaksi = $transaksi;
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

    public function wishlist()
    {
        $wishlist = $this->wishlist->search(new Request([
            'user_id' => Auth::user()->id
        ]));
        return view('home.wishlist', compact('wishlist'));
    }

    public function wishlist_save(Request $request)
    {
        $request->validate(['produk_id' => 'required']);
        return $this->wishlist->save(new Request([
            'produk_id' => $request->input('produk_id'),
            'user_id' => Auth::user()->id
        ]));
    }

    public function wishlist_delete(Request $request)
    {
        return $this->wishlist->delete($request->input('id'));
    }

    public function cart()
    {
        $cart = $this->cart->search(new Request([
            'user_id' => Auth::user()->id
        ]));
        return view('home.cart', compact('cart'));
    }

    public function cart_count()
    {
        return $this->cart->search(new Request([
            'user_id' => Auth::user()->id,
            'count' => 1
        ]));
    }

    public function cart_minimal()
    {
        $cart = $this->cart->search(new Request([
            'user_id' => Auth::user()->id
        ]));
        return view('home._cart', compact('cart'));
    }

    public function cart_save(Request $request)
    {
        $request->validate(['produk_id' => 'required']);
        return $this->cart->save(new Request([
            'produk_id' => $request->input('produk_id'),
            'user_id' => Auth::user()->id,
            'qty' => $request->input('qty') ?? 1
        ]));
    }

    public function cart_delete(Request $request)
    {
        return $this->cart->delete($request->input('id'));
    }

    public function alamat()
    {
        $alamat = $this->user->alamat(Auth::user()->id);
        return view('home.alamat', compact('alamat'));
    }

    public function alamat_save(Request $request)
    {
        $request->merge(['user_id' => Auth::user()->id]);
        $this->user->save_alamat($request);
        return redirect()->route('alamat')
            ->with('success', 'Alamat berhasil disimpan');
    }

    public function checkout()
    {
        $cart = $this->cart->search(new Request([
            'user_id' => Auth::user()->id
        ]));
        $alamat = $this->user->alamat(Auth::user()->id);
        return view('home.checkout', compact('cart', 'alamat'));
    }

    public function checkout_save(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->merge(['user_id' => $user_id]);
        $request->merge(['status' => 'Menunggu Validasi Toko']);
        $request->merge(['tanggal' => date('Y-m-d')]);

        $alamat = $this->user->save_alamat($request);
        $request->merge(['alamat_pengiriman' => $alamat->alamat]);
        $this->transaksi->save($request);
        return redirect()->route('transaksi');
    }

    public function transaksi()
    {
        $transaksi = $this->transaksi->transaksi(Auth::user()->id);
        return view('home.transaksi', compact('transaksi'));
    }

    public function transaksi_detail($no_transaksi)
    {
        $transaksi = $this->transaksi->find($no_transaksi, 'no_transaksi');
        return view('home.transaksi_detail', compact('transaksi'));
    }

    public function transaksi_save(Request $request)
    {
        $filename = $this->save_file($request, 'bukti_transfer');
        if ($filename != '') $request->merge(['file_bukti' => $filename]);
        $transaksi = $this->transaksi->save($request);
        return redirect()->route('transaksi.detail', $transaksi->no_transaksi);
    }
}
