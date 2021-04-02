<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimpananSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'member_id' => 'required',
            'jenis_simpanan_id' => 'required',
            'no_simpanan' => 'required',
            'tanggal' => 'required',
            'nominal' => 'required',
        ];
    }
}
