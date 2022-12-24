<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KasirController extends Controller
{
    public function index()
    {
        return view('kasir.index');
    }

    public function info(Request $request)
    {
        $transaksi = Transaksi::find($request->input('id') ?? '');
        return view('kasir.info', compact('transaksi'));
    }

    public function search(Request $request)
    {
        $transaksi = Transaksi::whereNull('user_id')->orderBy('tanggal', 'desc')->paginate($request->input('paginate'));
        return view('kasir._table', compact('transaksi'));
    }

    public function search_item(Request $request)
    {
        $list_items = session('list_items', []);
        $products = [];
        $transaksi = Transaksi::find($request->input('transaksi_id') ?? '');

        foreach (Produk::get() as $value) $products[$value->id] = $value->nama;
        return view('kasir._item', compact('list_items', 'products', 'transaksi'));
    }

    public function save_item(Request $request)
    {
        $list_items = session('list_items', []);
        $produk_id = $request->input('produk_id');
        $item = [
            'uuid' => Str::uuid(),
            'produk_id' => $produk_id,
            'produk' => Produk::find($produk_id),
            'qty' => unformat_number($request->input('qty')),
            'harga' =>unformat_number( $request->input('harga')),
            'harga_beli' => unformat_number($request->input('harga_beli'))
        ];
        array_push($list_items, $item);
        session(['list_items' => $list_items]);
        return $item;
    }

    public function delete_item(Request $request)
    {
        $list_items = session('list_items', []);
        $uuid = $request->input('id');
        $list_items = array_filter($list_items, function ($item) use ($uuid) {
            return $item['uuid'] != $uuid;
        });
        session(['list_items' => $list_items]);
    }

    public function save(Request $request)
    {
        $transaksi = Transaksi::find($request->input('id') ?? '');
        if (empty($transaksi)) {
            $transaksi = Transaksi::create([
                'user_id' => null,
                'no_transaksi' => $request->input('no_transaksi') == 'Otomatis' ? $this->auto_number() : $request->input('no_transaksi'),
                'tanggal' => unformat_date($request->input('tanggal')),
            ]);
        } else {
            $transaksi->update([
                'no_transaksi' => $request->input('no_transaksi'),
                'tanggal' => unformat_date($request->input('tanggal')),
            ]);
        }
        $list_items = session('list_items', []);
        foreach ($list_items as $item) {
            if ($item['produk_id'] != '') {
                $produk = Produk::find($item['produk_id']);
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['produk_id'],
                    'qty' => unformat_number($item['qty']),
                    'harga' => unformat_number($item['harga']),
                    'harga_beli' => $produk->harga_beli,
                ]);
            }
        }
        session(['list_items' => [session(['list_items' => $list_items])]]);
        return redirect()->route('admin.kasir');
    }

    public function delete(Request $request)
    {
        session(['list_items' => [session(['list_items' => $list_items])]]);
        return Transaksi::where('id', $request->input('id'))->delete();
    }

    public function auto_number()
    {
        $last = Transaksi::orderBy('no_transaksi', 'desc')->first();
        $last_no = empty($last) ? 1 : intval($last->no_transaksi)+1;
        for ($i = 1; strlen($last_no) <= 9; $i++) $last_no = '0' . $last_no;
        return $last_no;
    }

}
