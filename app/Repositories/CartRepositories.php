<?php

namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartRepositories extends Repository {

    protected $cart;
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function search(Request $request)
    {
        $cart = $this->cart;

        $user_id = $request->input('user_id') ?? '';
        if ($user_id != '')
            $cart = $cart->where('user_id', $user_id);

        $paginate = $request->input('paginate') ?? null;
        if ($paginate != null) return $cart->paginate($paginate);
        return $cart->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->cart->where($column, $value)->first();
    }

    public function save(Request $request)
    {
        $cart = $this->cart->firstOrCreate([
            'user_id' => $request->input('user_id'),
            'produk_id' => $request->input('produk_id')
        ]);
        $qty = $request->input('qty') ?? '';
        if ($qty != '') {
            $cart->qty = unformat_number($qty);
        } else {
            $cart->qty = $cart+1;
        }
        $cart->save();
        return $cart;
    }

    public function delete($id)
    {
        $cart = $this->cart->find($id);
        if (!empty($cart)) $cart->delete();
        return $cart;
    }

}
