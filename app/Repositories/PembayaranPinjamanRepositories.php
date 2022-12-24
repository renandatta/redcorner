<?php

namespace App\Repositories;

use App\Models\PembayaranPinjaman;
use Illuminate\Http\Request;

class PembayaranPinjamanRepositories extends Repository {

    protected $pembayaranPinjaman;
    public function __construct(PembayaranPinjaman $pembayaranPinjaman)
    {
        $this->pembayaranPinjaman = $pembayaranPinjaman;
    }

    public function search(Request $request)
    {
        $pembayaranPinjaman = $this->pembayaranPinjaman
            ->with(['pinjaman'])
            ->oldest();

        $pinjaman_id = $request->input('pinjaman_id') ?? '';
        if ($pinjaman_id != '')
            $pembayaranPinjaman = $pembayaranPinjaman->where('pinjaman_id', $pinjaman_id);

        $member_id = $request->input('member_id') ?? '';
        if ($member_id != '')
            $pembayaranPinjaman = $pembayaranPinjaman->whereHas('pinjaman', function ($pinjaman) use ($member_id) {
                $pinjaman->where('member_id', $member_id);
            });

        $select = $request->input('select') ?? '';
        if ($select != '') $pembayaranPinjaman = $pembayaranPinjaman->select($select);

        $tanggal_awal = $request->input('tanggal_awal', '') ?? '';
        if ($tanggal_awal !== '')
            $pembayaranPinjaman = $pembayaranPinjaman->where('tanggal', '>=', unformat_date($tanggal_awal));

        $tanggal_akhir = $request->input('tanggal_akhir', '') ?? '';
        if ($tanggal_akhir !== '')
            $pembayaranPinjaman = $pembayaranPinjaman->where('tanggal', '<=', unformat_date($tanggal_akhir));

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $pembayaranPinjaman->paginate($paginate);
        return $pembayaranPinjaman->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->pembayaranPinjaman->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $request = $this->clean_number($request, ['nominal']);
        $request = $this->clean_date($request, ['tanggal']);
        $pembayaranPinjaman = $this->pembayaranPinjaman->find($request->input('id'));
        if (empty($pembayaranPinjaman)) $pembayaranPinjaman = $this->pembayaranPinjaman->create($request->all());
        else $pembayaranPinjaman->update($request->all());
        return $pembayaranPinjaman;
    }

    public function delete($id)
    {
        $pembayaranPinjaman = $this->pembayaranPinjaman->find($id);
        if (!empty($pembayaranPinjaman)) $pembayaranPinjaman->delete();
        return $pembayaranPinjaman;
    }

    public function auto_number($pinjaman_id)
    {
        $last = $this->pembayaranPinjaman
            ->where('pinjaman_id', $pinjaman_id)
            ->orderBy('pembayaran_ke', 'desc')
            ->first();
        $last_no = empty($last) ? 1 : intval($last->pembayaran_ke)+1;
        return $last_no;
    }

}
