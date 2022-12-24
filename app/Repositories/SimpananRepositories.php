<?php

namespace App\Repositories;

use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimpananRepositories extends Repository {

    protected $simpanan;
    public function __construct(Simpanan $simpanan)
    {
        $this->simpanan = $simpanan;
    }

    public function search(Request $request)
    {
        $simpanan = $this->simpanan
            ->with(['member', 'jenis_simpanan'])
            ->latest();

        $member_id = $request->input('member_id') ?? '';
        if ($member_id != '')
            $simpanan = $simpanan->where('member_id', $member_id);

        $tanggal_awal = $request->input('tanggal_awal', '');
        if ($tanggal_awal !== '')
            $simpanan = $simpanan->where('tanggal', '>=', unformat_date($tanggal_awal));

        $tanggal_akhir = $request->input('tanggal_akhir', '');
        if ($tanggal_akhir !== '')
            $simpanan = $simpanan->where('tanggal', '<=', unformat_date($tanggal_akhir));

        $select = $request->input('select') ?? '';
        if ($select != '') $simpanan = $simpanan->select($select);

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $simpanan->paginate($paginate);
        return $simpanan->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->simpanan->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $request = $this->clean_number($request, ['nominal']);
        $request = $this->clean_date($request, ['tanggal']);
        $simpanan = $this->simpanan->find($request->input('id'));
        if (empty($simpanan)) $simpanan = $this->simpanan->create($request->all());
        else $simpanan->update($request->all());
        return $simpanan;
    }

    public function delete($id)
    {
        $simpanan = $this->simpanan->find($id);
        if (!empty($simpanan)) $simpanan->delete();
        return $simpanan;
    }

    public function auto_number()
    {
        $last = $this->simpanan
            ->orderBy('no_simpanan', 'desc')
            ->first();
        $last_no = empty($last) ? 1 : intval($last->no_simpanan)+1;
        for ($i = 1; strlen($last_no) <= 9; $i++) $last_no = '0' . $last_no;
        return $last_no;
    }

}
