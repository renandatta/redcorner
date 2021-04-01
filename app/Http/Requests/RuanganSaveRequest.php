<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RuanganSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama' => 'required',
            'harga' => 'required',
        ];
    }
}
