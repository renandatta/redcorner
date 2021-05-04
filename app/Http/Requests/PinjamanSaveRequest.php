<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PinjamanSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'member_id' => 'required',
            'no_pinjaman' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required',
        ];
    }
}
