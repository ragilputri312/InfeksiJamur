<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DsRuleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get valid keunikan values from database
        $validKeunikan = \App\Models\FuzzyParameter::where('tipe', 'keunikan')
            ->where('is_active', true)
            ->pluck('label')
            ->toArray();

        // Fallback to default values if no data in database
        if (empty($validKeunikan)) {
            $validKeunikan = ['Rendah', 'Sedang', 'Tinggi'];
        }

        return [
            'penyakit_id' => 'required|exists:tblpenyakit,id',
            'gejala_id' => 'required|exists:tblgejala,id',
            'keunikan' => 'required|in:' . implode(',', $validKeunikan),
            'deskripsi' => 'nullable|string|max:500',
            'is_active' => 'nullable|in:on,1,true',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->penyakit_id && $this->gejala_id) {
                $exists = \App\Models\DsRule::where('penyakit_id', $this->penyakit_id)
                    ->where('gejala_id', $this->gejala_id)
                    ->exists();

                if ($exists) {
                    $validator->errors()->add('gejala_id', 'Kombinasi penyakit dan gejala ini sudah ada. Silakan pilih kombinasi yang berbeda.');
                }
            }
        });
    }

    public function messages(): array
    {
        // Get valid keunikan values for error message
        $validKeunikan = \App\Models\FuzzyParameter::where('tipe', 'keunikan')
            ->where('is_active', true)
            ->pluck('label')
            ->toArray();

        if (empty($validKeunikan)) {
            $validKeunikan = ['Rendah', 'Sedang', 'Tinggi'];
        }

        $keunikanList = implode(', ', $validKeunikan);

        return [
            'penyakit_id.required' => 'Penyakit harus dipilih.',
            'penyakit_id.exists' => 'Penyakit yang dipilih tidak valid.',
            'gejala_id.required' => 'Gejala harus dipilih.',
            'gejala_id.exists' => 'Gejala yang dipilih tidak valid.',
            'keunikan.required' => 'Keunikan harus dipilih.',
            'keunikan.in' => 'Keunikan harus salah satu dari: ' . $keunikanList . '.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
            'is_active.in' => 'Status aktif tidak valid.',
        ];
    }
}
