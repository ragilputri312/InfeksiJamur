<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PenyakitUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id') ?? $this->route('penyakit');
        return [
            'kode_penyakit' => [
                'required', 'string', 'max:50',
                Rule::unique('tblpenyakit', 'kode_penyakit')->ignore($id, 'id'),
            ],
            'penyakit' => 'required|string|max:255',
            'penangan' => 'required|string',
        ];
    }
}
