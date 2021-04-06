<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\JenisSimpananSaveRequest;
use App\Repositories\JenisSimpananRepositories;
use Illuminate\Http\Request;

class JenisSimpananController extends Controller
{
    protected $jenisSimpanan;
    public function __construct(JenisSimpananRepositories $jenisSimpanan)
    {
        $this->middleware(['auth', 'user_role']);
        $this->jenisSimpanan = $jenisSimpanan;
        view()->share(['list_tipe' => $jenisSimpanan->dropdown_tipe()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.jenis_simpanan']);
        return view('jenis_simpanan.index');
    }

    public function search(Request $request)
    {
        $jenis_simpanan = $this->jenisSimpanan->search($request);
        return view('jenis_simpanan._table', compact('jenis_simpanan'));
    }

    public function info(Request $request)
    {
        $jenis_simpanan = $this->jenisSimpanan->find($request->input('id'));
        if ($request->has('ajax')) return $jenis_simpanan;
        return view('jenis_simpanan._info', compact('jenis_simpanan'));
    }

    public function save(JenisSimpananSaveRequest $request)
    {
        return $this->jenisSimpanan->save($request);
    }

    public function delete(DeleteRequest $request)
    {
        return $this->jenisSimpanan->delete($request->input('id'));
    }
}
