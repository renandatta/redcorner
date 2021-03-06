<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\UserSaveRequest;
use App\Repositories\UserRepositories;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    public function __construct(UserRepositories $user)
    {
        $this->middleware(['auth', 'user_role']);
        $this->user = $user;
        view()->share(['list_role' => $user->list_role()]);
    }

    public function index()
    {
        session(['menu_active' => 'admin.user']);
        return view('user.index');
    }

    public function search(Request $request)
    {
        $user = $this->user->search($request);
        return view('user._table', compact('user'));
    }

    public function info(Request $request)
    {
        $user = $this->user->find($request->input('id'));
        return view('user._info', compact('user'));
    }

    public function save(UserSaveRequest $request)
    {
        return $this->user->save($request);
    }

    public function delete(DeleteRequest $request)
    {
        return $this->user->delete($request->input('id'));
    }
}
