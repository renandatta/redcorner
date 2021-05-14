<?php

namespace App\Repositories;

use App\Models\AlamatUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepositories {

    protected $user, $alamat;
    public function __construct(User $user, AlamatUser $alamat)
    {
        $this->user = $user;
        $this->alamat = $alamat;
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

    public function list_role()
    {
        $result = array();
        foreach (User::ROLES as $value) $result[$value] = $value;
        return $result;
    }

    public function alamat($user_id)
    {
        return $this->alamat->where('user_id', $user_id)->first();
    }

    public function save_alamat(Request $request)
    {
        return $this->alamat->updateOrCreate([
            'user_id' => $request->input('user_id')
        ], [
            'alamat' => $request->input('alamat'),
            'kodepos' => $request->input('kodepos'),
            'nama_penerima' => $request->input('nama_penerima'),
            'notelp' => $request->input('notelp')
        ]);
    }

}
