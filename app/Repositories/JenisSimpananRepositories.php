<?php

namespace App\Repositories;

use App\Models\JenisSimpanan;
use Illuminate\Http\Request;

class JenisSimpananRepositories extends Repository {

    protected $jenisSimpanan;
    public function __construct(JenisSimpanan $jenisSimpanan)
    {
        $this->jenisSimpanan = $jenisSimpanan;
    }

    public function search(Request $request)
    {
        $jenisSimpanan = $this->jenisSimpanan;

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $jenisSimpanan->paginate($paginate);
        return $jenisSimpanan->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->jenisSimpanan->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $request = $this->clean_number($request, ['nominal']);
        $jenisSimpanan = $this->jenisSimpanan->find($request->input('id'));
        if (empty($jenisSimpanan)) $jenisSimpanan = $this->jenisSimpanan->create($request->all());
        else $jenisSimpanan->update($request->all());
        return $jenisSimpanan;
    }

    public function delete($id)
    {
        $jenisSimpanan = $this->jenisSimpanan->find($id);
        if (!empty($jenisSimpanan)) $jenisSimpanan->delete();
        return $jenisSimpanan;
    }

    public function dropdown_tipe()
    {
        $result = array();
        foreach (JenisSimpanan::TIPE as $item) $result[$item] = $item;
        return $result;
    }

    public function dropdown()
    {
        $result = array();
        $data = $this->jenisSimpanan->get();
        foreach ($data as $value) $result[$value->id] = $value->tipe . ' - ' . $value->nama;
        return $result;
    }

}
