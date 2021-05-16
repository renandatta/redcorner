<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;

class TransaksiRepositories extends Repository
{
    protected $transaksi, $cart, $detail;
    public function __construct(Transaksi $transaksi, Cart $cart, TransaksiDetail $detail)
    {
        $this->transaksi = $transaksi;
        $this->cart = $cart;
        $this->detail = $detail;
    }

    public function search(Request $request)
    {
        $transaksi = $this->transaksi
            ->with(['user', 'detail'])
            ->orderBy('no_transaksi', 'asc');

        $status = $request->input('status') ?? '';
        if ($status != '') $transaksi = $transaksi->where('status', $status);

        $select = $request->input('select') ?? '';
        if ($select != '') $transaksi = $transaksi->select($select);

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $transaksi->paginate($paginate);
        return $transaksi->get();
    }

    public function transaksi($user_id)
    {
        return $this->transaksi
            ->where('user_id', $user_id)
            ->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->transaksi->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $request = $this->clean_number($request, ['biaya_pengiriman', 'diskon', 'nominal_transfer']);
        $transaksi = $this->transaksi->find($request->input('id') ?? '');
        if (empty($transaksi)) {
            $request->merge(['no_transaksi' => $this->auto_number()]);
            $transaksi = $this->transaksi->create($request->all());
            $this->save_from_cart($transaksi->id, $transaksi->user_id);
        } else {
            $biaya_pengiriman = floatval($request->input('biaya_pengiriman'));
            $diskon = floatval($request->input('diskon'));
            $total = $transaksi->harga_produk + $biaya_pengiriman - $diskon;
            $request->merge(['total_biaya' => $total]);

            $status = '';
            if ($transaksi->status == 'Menunggu Validasi Toko' && $biaya_pengiriman !== '') $status = 'Pembelian Divalidasi';
            if ($transaksi->status == 'Pembelian Divalidasi' && ($request->input('nominal_transfer') ?? '') !== '') $status = 'Menunggu Validasi Pembayaran';
            if ($transaksi->status == 'Menunggu Validasi Pembayaran' && ($request->input('no_resi') ?? '') !== '') $status = 'Proses Pengiriman';

            if ($status !== '') $request->merge(['status' => $status]);
            $transaksi->update($request->all());
        }
        return $transaksi;
    }

    public function save_from_cart($transaksi_id, $user_id)
    {
        $cart = $this->cart->where('user_id', $user_id)->get();
        foreach ($cart as $item) {
            $this->detail->create([
                'transaksi_id' => $transaksi_id,
                'produk_id' => $item->produk_id,
                'qty' => $item->qty,
                'harga' => $item->produk->harga,
                'harga_beli' => $item->produk->harga_beli
            ]);
        }
        $this->cart->where('user_id', $user_id)->delete();
        $this->transaksi->where('id', $transaksi_id)->update([
            'harga_produk' => $cart->sum('total'),
            'harga_beli' => $cart->sum('total_harga_beli')
        ]);
    }

    public function auto_number()
    {
        $last = $this->transaksi
            ->orderBy('no_transaksi', 'desc')
            ->first();
        $last_no = empty($last) ? 1 : intval($last->no_transaksi)+1;
        for ($i = 1; strlen($last_no) <= 9; $i++) $last_no = '0' . $last_no;
        return $last_no;
    }

    public function list_status()
    {
        $status = array('Menunggu Validasi Toko', 'Pembelian Divalidasi', 'Menunggu Validasi Pembayaran', 'Proses Pengiriman', 'Selesai');
        $result = [];
        foreach ($status as $item) $result[$item] = $item;
        return $result;
    }
}
