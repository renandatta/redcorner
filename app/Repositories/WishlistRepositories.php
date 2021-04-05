<?php

namespace App\Repositories;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistRepositories extends Repository {

    protected $wishlist;
    public function __construct(Wishlist $wishlist)
    {
        $this->wishlist = $wishlist;
    }

    public function search(Request $request)
    {
        $wishlist = $this->wishlist;

        $user_id = $request->input('user_id') ?? '';
        if ($user_id != '')
            $wishlist = $wishlist->where('user_id', $user_id);

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $wishlist->paginate($paginate);
        return $wishlist->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->wishlist->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        return $this->wishlist->firstOrCreate([
            'user_id' => $request->input('user_id'),
            'produk_id' => $request->input('produk_id')
        ]);
    }

    public function delete($id)
    {
        $wishlist = $this->wishlist->find($id);
        if (!empty($wishlist)) $wishlist->delete();
        return $wishlist;
    }

}
