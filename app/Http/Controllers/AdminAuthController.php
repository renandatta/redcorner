<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Repositories\UserRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{

    protected $user;
    public function __construct(UserRepositories $user)
    {
        $this->user = $user;
    }

    public function login()
    {
        return view('auth.admin');
    }

    public function proses(AuthRequest $request)
    {
        $user = $this->user->find($request->input('email'), 'email');
        if (empty($user) && !Hash::check($request->input('password'), $user->password))
            return redirect()->route('admin.login');
        Auth::login($user, $request->has('remember'));
        return redirect()->route('admin');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('/');
    }
}
