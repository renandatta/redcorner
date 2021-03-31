<?php

namespace App\Repositories;

use Illuminate\Http\Request;

class Repository {

    public function clean_date(Request $request, $inputs)
    {
        foreach ($inputs as $input) {
            if ($request->has($input))
                $request->merge([$input => unformat_date($request->input($input))]);
        }
        return $request;
    }

    public function clean_number(Request $request, $inputs)
    {
        foreach ($inputs as $input) {
            if ($request->has($input))
                $request->merge([$input => unformat_number($request->input($input))]);
        }
        return $request;
    }

    public function auto_kode($model, $parent_kode = '#')
    {
        $last_row = $model->where('parent_kode', $parent_kode)
            ->orderBy('kode', 'desc')->first();

        $kode = !empty($last_row) ? intval(last(explode('.', $last_row->kode))) + 1 : 1;
        $kode = strlen($kode) == 1 ? $kode = '0' . $kode : $kode;
        return $parent_kode == '#' ? $kode : "$parent_kode.$kode";
    }

}
