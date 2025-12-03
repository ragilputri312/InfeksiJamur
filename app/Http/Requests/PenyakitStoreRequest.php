<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenyakitStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_penyakit' => 'required|string|max:50|unique:tblpenyakit,kode_penyakit',
            'penyakit' => 'required|string|max:255',
            'penangan' => 'required|string',
        ];
    }
}
