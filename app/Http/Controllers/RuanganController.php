<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\RuanganSaveRequest;
use App\Repositories\KategoriRepositories;
use App\Repositories\RuanganRepositories;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    protected $ruangan;
    public function __construct(RuanganRepositories $ruangan, KategoriRepositories $kategori)
    {
        $this->middleware(['auth', 'user_role']);
        $this->ruangan = $ruangan;
        view()->share(['list_kategori' => $kategori->dropdown()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.ruangan']);
        return view('ruangan.index');
    }

    public function search(Request $request)
    {
        $ruangan = $this->ruangan->search($request);
        return view('ruangan._table', compact('ruangan'));
    }

    public function info(Request $request)
    {
        $ruangan = $this->ruangan->find($request->input('id'));
        return view('ruangan._info', compact('ruangan'));
    }

    public function save(RuanganSaveRequest $request)
    {
        $filename = $this->save_file($request);
        if ($filename != '') $request->merge(['gambar' => $filename]);
        return $this->ruangan->save($request);
    }

    public function delete(DeleteRequest $request)
    {
        return $this->ruangan->delete($request->input('id'));
    }

    public function delete_gambar(Request $request)
    {
        $gambar = $this->ruangan->delete_gambar($request->input('id'));
        if (!empty($gambar)) $this->delete_file($gambar->file);
        return $gambar;
    }
}
