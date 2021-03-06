<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'user_role']);
    }

    public function index()
    {
        session((['menu_active' => 'admin']));
        return view('layouts.index');
    }
}
