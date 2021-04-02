<?php

namespace App\Repositories;

use App\Models\GambarRuangan;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganRepositories extends Repository {

    protected $ruangan, $gambar;
    public function __construct(Ruangan $ruangan, GambarRuangan $gambar)
    {
        $this->ruangan = $ruangan;
        $this->gambar = $gambar;
    }

    public function search(Request $request)
    {
        $ruangan = $this->ruangan->orderBy('id', 'desc');

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $ruangan->paginate($paginate);
        return $ruangan->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->ruangan->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $request = $this->clean_number($request, ['harga']);
        $ruangan = $this->ruangan->find($request->input('id'));
        if (empty($ruangan)) $ruangan = $this->ruangan->create($request->all());
        else $ruangan->update($request->all());
        if ($request->has('gambar')) $this->save_gambar($ruangan->id, $request->input('gambar'));
        return $ruangan;
    }

    public function delete($id)
    {
        $ruangan = $this->ruangan->find($id);
        if (!empty($ruangan)) $ruangan->delete();
        $this->gambar->where('ruangan_id', $id)->delete();
        return $ruangan;
    }

    public function save_gambar($ruangan_id, $filename)
    {
        return $this->gambar->create([
            'ruangan_id' => $ruangan_id,
            'file' => $filename
        ]);
    }

    public function delete_gambar($id)
    {
        $gambar = $this->gambar->find($id);
        if (!empty($gambar)) $gambar->delete();
        return $gambar;
    }

    public function ruangan_utama()
    {
        return $this->ruangan->latest()->first();
    }

}
