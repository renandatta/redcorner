<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $user;
    public function __construct(UserRepositories $user)
    {
        $this->user = $user;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function login_proses(AuthRequest $request)
    {
        $user = $this->user->find($request->input('email'), 'email');
        if (empty($user)) return redirect()->route('login');
        if (!Hash::check($request->input('password'), $user->password))
        return redirect()->route('login');
        Auth::login($user, $request->has('remember'));

        if ($user->role == 'User') return redirect()->route('/');
        if ($user->role == 'Administrator') return redirect()->route('admin');
    }

    public function register_proses(RegisterRequest $request)
    {
        $request->merge(['role' => 'User']);
        $user = $this->user->save($request);
        Auth::login($user, true);
        return redirect()->route('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('/');
    }
}
