<?php

namespace App\Repositories;

use App\Models\GambarProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukRepositories extends Repository {

    protected $produk, $gambar;
    protected $kategori_tumpeng, $kategori_sembako;
    public function __construct(Produk $produk, GambarProduk $gambar, KategoriRepositories $kategori)
    {
        $this->produk = $produk;
        $this->gambar = $gambar;
        $this->kategori_sembako = $kategori->find('Sembako', 'nama');
        $this->kategori_tumpeng = $kategori->find('Tumpeng', 'nama');
    }

    public function search(Request $request)
    {
        $produk = $this->produk->with(['kategori', 'gambar'])
            ->orderBy('id', 'desc');

        $id_not = $request->input('id_not') ?? '';
        if ($id_not != '')
            $produk = $produk->where('id', '<>', $id_not);

        $is_produk = $request->input('is_produk') ?? '';
        if ($is_produk != '')
            $produk = $produk->whereHas('kategori', function ($kategori) {
                $kategori->where('kode', 'not like', $this->kategori_sembako->kode.'%')
                    ->where('kode', 'not like', $this->kategori_tumpeng->kode.'%');
            });

        $kategori_kode = $request->input('kategori_kode') ?? '';
        if ($kategori_kode != '')
            $produk->whereHas('kategori', function ($kategori) use ($kategori_kode) {
                $kategori->where('kode', 'like', "$kategori_kode%");
            });

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $produk->paginate($paginate);
        return $produk->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->produk->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $request = $this->clean_number($request, ['harga', 'harga_beli']);
        $produk = $this->produk->find($request->input('id'));
        if (empty($produk)) $produk = $this->produk->create($request->all());
        else $produk->update($request->all());
        if ($request->has('gambar')) $this->save_gambar($produk->id, $request->input('gambar'));
        return $produk;
    }

    public function delete($id)
    {
        $produk = $this->produk->find($id);
        if (!empty($produk)) $produk->delete();
        $this->gambar->where('produk_id', $id)->delete();
        return $produk;
    }

    public function save_gambar($produk_id, $filename)
    {
        return $this->gambar->create([
            'produk_id' => $produk_id,
            'file' => $filename
        ]);
    }

    public function delete_gambar($id)
    {
        $gambar = $this->gambar->find($id);
        if (!empty($gambar)) $gambar->delete();
        return $gambar;
    }

    public function featured_produk()
    {
        return $this->produk
            ->whereHas('kategori', function ($kategori) {
                $kategori->where('kode', 'not like', $this->kategori_sembako->kode.'%')
                    ->where('kode', 'not like', $this->kategori_tumpeng->kode.'%');
            })
            ->with(['gambar'])
            ->has('gambar')
            ->latest()->get();
    }

    public function sembako(Request $request)
    {
        $request->merge(['kategori_kode' => $this->kategori_sembako->kode]);
        return $this->search($request);
    }

    public function tumpeng(Request $request)
    {
        $request->merge(['kategori_kode' => $this->kategori_tumpeng->kode]);
        return $this->search($request);
    }

    public function produk(Request $request)
    {
        $request->merge(['is_produk' => '1']);
        return $this->search($request);
    }

}
