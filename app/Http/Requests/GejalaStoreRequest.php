<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GejalaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_gejala' => 'required|string|max:50|unique:tblgejala,kode_gejala',
            'gejala' => 'required|string|max:255',
            'pertanyaan' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:0',
        ];
    }
}
