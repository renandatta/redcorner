<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\KategoriSaveRequest;
use App\Repositories\KategoriRepositories;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    protected $kategori;
    public function __construct(KategoriRepositories $kategori)
    {
        $this->middleware(['auth', 'user_role']);
        $this->kategori = $kategori;
    }

    public function index()
    {
        session(['menu_active' => 'admin.kategori']);
        return view('kategori.index');
    }

    public function search(Request $request)
    {
        $kategori = $this->kategori->search($request);
        $kategori = $this->kategori->nested_data($kategori);
        return view('kategori._table', compact('kategori'));
    }

    public function info(Request $request)
    {
        $kategori = $this->kategori->find($request->input('id'));
        $parent_kode = !empty($kategori) ? $kategori->kode : ($request->input('parent_kode') ?? '#');
        $kode = !empty($kategori) ? $kategori->kode : $this->kategori->kode($parent_kode);
        return view('kategori._info', compact('kategori', 'parent_kode', 'kode'));
    }

    public function save(KategoriSaveRequest $request)
    {
        return $this->kategori->save($request);
    }

    public function delete(DeleteRequest $request)
    {
        return $this->kategori->delete($request->input('id'));
    }
}
