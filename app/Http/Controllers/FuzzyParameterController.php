<?php

namespace App\Http\Controllers;

use App\Models\FuzzyParameter;
use Illuminate\Http\Request;

class FuzzyParameterController extends Controller
{
    public function index()
    {
        $kemunculanParams = FuzzyParameter::byTipe('kemunculan')
            ->orderBy('urutan')
            ->get();

        $keunikanParams = FuzzyParameter::byTipe('keunikan')
            ->orderBy('urutan')
            ->get();

        return view('admin.fuzzy-parameters.index', compact('kemunculanParams', 'keunikanParams'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe' => 'required|in:kemunculan,keunikan',
            'label' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0|max:1',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer|min:0'
        ]);

        $validated['is_active'] = $request->has('is_active');

        FuzzyParameter::create($validated);

        return redirect()->route('fuzzy-parameters.index')
            ->with('success', 'Parameter fuzzy berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $parameter = FuzzyParameter::findOrFail($id);

        $validated = $request->validate([
            'tipe' => 'required|in:kemunculan,keunikan',
            'label' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0|max:1',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer|min:0'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $parameter->update($validated);

        return redirect()->route('fuzzy-parameters.index')
            ->with('success', 'Parameter fuzzy berhasil diupdate');
    }

    public function destroy($id)
    {
        $parameter = FuzzyParameter::findOrFail($id);

        // Check if parameter is being used
        $isUsedInRules = false;
        $isUsedInDiagnosis = false;

        if ($parameter->tipe === 'keunikan') {
            // Check if used in ds_rules
            $isUsedInRules = \App\Models\DsRule::where('fuzzy_parameter_id', $id)->exists();
        } elseif ($parameter->tipe === 'kemunculan') {
            // Check if used in ds_diagnosis_details
            $isUsedInDiagnosis = \App\Models\DsDiagnosisDetail::where('kemunculan_fuzzy_parameter_id', $id)->exists();
        }

        if ($isUsedInRules) {
            return redirect()->route('fuzzy-parameters.index')
                ->with('error', 'Tidak dapat menghapus parameter "' . $parameter->label . '" karena masih digunakan dalam relasi gejala-penyakit. Silakan hapus relasi tersebut terlebih dahulu atau nonaktifkan parameter ini.');
        }

        if ($isUsedInDiagnosis) {
            return redirect()->route('fuzzy-parameters.index')
                ->with('error', 'Tidak dapat menghapus parameter "' . $parameter->label . '" karena masih digunakan dalam riwayat diagnosis. Silakan nonaktifkan parameter ini jika tidak ingin digunakan lagi.');
        }

        try {
            $parameter->delete();
            return redirect()->route('fuzzy-parameters.index')
                ->with('success', 'Parameter fuzzy "' . $parameter->label . '" berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Catch any other foreign key constraint errors
            return redirect()->route('fuzzy-parameters.index')
                ->with('error', 'Tidak dapat menghapus parameter "' . $parameter->label . '" karena masih digunakan dalam sistem. Silakan nonaktifkan parameter ini sebagai gantinya.');
        }
    }

    public function toggleStatus($id)
    {
        $parameter = FuzzyParameter::findOrFail($id);
        $parameter->is_active = !$parameter->is_active;
        $parameter->save();

        return redirect()->route('fuzzy-parameters.index')
            ->with('success', 'Status parameter berhasil diubah');
    }
}
