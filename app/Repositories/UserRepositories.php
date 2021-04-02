<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepositories {

    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function search(Request $request)
    {
        $user = $this->user;

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $user->paginate($paginate);
        return $user->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->user->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $user = $this->user->find($request->input('id'));
        if (empty($user)) $user = $this->user->create($request->all());
        else $user->update($request->all());
        if ($request->input('password') ?? '')
            $user->update(['password' => Hash::make($request->input('password'))]);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->user->find($id);
        if (!empty($user)) $user->delete();
        return $user;
    }

}
