<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\MemberSaveRequest;
use App\Repositories\MemberRepositories;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    protected $member;
    public function __construct(MemberRepositories $member)
    {
        $this->middleware('auth');
        $this->member = $member;
        view()->share(['list_jenis_kelamin' => $member->dropdown_jenis_kelamin()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.member']);
        return view('member.index');
    }

    public function search(Request $request)
    {
        $member = $this->member->search($request);
        return view('member._table', compact('member'));
    }

    public function info(Request $request)
    {
        $member = $this->member->find($request->input('id'));
        return view('member._info', compact('member'));
    }

    public function save(MemberSaveRequest $request)
    {
        return $this->member->save($request);
    }

    public function delete(DeleteRequest $request)
    {
        return $this->member->delete($request->input('id'));
    }
}
