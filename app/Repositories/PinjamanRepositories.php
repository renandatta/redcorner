<?php

namespace App\Repositories;

use App\Models\Pinjaman;
use Illuminate\Http\Request;

class PinjamanRepositories extends Repository {

    protected $pinjaman;
    public function __construct(Pinjaman $pinjaman)
    {
        $this->pinjaman = $pinjaman;
    }

    public function search(Request $request)
    {
        $pinjaman = $this->pinjaman
            ->with(['member'])
            ->latest();

        $member_id = $request->input('member_id') ?? '';
        if ($member_id != '')
            $pinjaman = $pinjaman->where('member_id', $member_id);

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $pinjaman->paginate($paginate);
        return $pinjaman->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->pinjaman->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $request = $this->clean_number($request, ['nominal', 'bunga', 'bunga_rupiah', 'angsuran']);
        $request = $this->clean_date($request, ['tanggal']);
        $pinjaman = $this->pinjaman->find($request->input('id'));
        if (empty($pinjaman)) $pinjaman = $this->pinjaman->create($request->all());
        else $pinjaman->update($request->all());
        return $pinjaman;
    }

    public function delete($id)
    {
        $pinjaman = $this->pinjaman->find($id);
        if (!empty($pinjaman)) $pinjaman->delete();
        return $pinjaman;
    }

    public function auto_number()
    {
        $last = $this->pinjaman
            ->orderBy('no_pinjaman', 'desc')
            ->first();
        $last_no = empty($last) ? 1 : intval($last->no_pinjaman)+1;
        for ($i = 1; strlen($last_no) <= 9; $i++) $last_no = '0' . $last_no;
        return $last_no;
    }

}
