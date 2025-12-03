<?php

namespace App\Http\Controllers;

use App\Models\DsRule;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Http\Requests\DsRuleStoreRequest;
use App\Http\Requests\DsRuleUpdateRequest;
use Illuminate\Http\Request;

class DsRuleController extends Controller
{
    public function index()
    {
        $dsRules = DsRule::with(['penyakit', 'gejala', 'fuzzyParameter'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $penyakit = Penyakit::orderBy('kode_penyakit')->get();
        $gejala = Gejala::where('is_active', true)->orderBy('urutan')->orderBy('kode_gejala')->get();

        // Get keunikan options from fuzzy parameters
        $keunikanOptions = \App\Models\FuzzyParameter::where('tipe', 'keunikan')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return view('admin.ds-rules.index', compact('dsRules', 'penyakit', 'gejala', 'keunikanOptions'));
    }


    public function store(DsRuleStoreRequest $request)
    {
        // Get fuzzy_parameter_id from keunikan label
        $fuzzyParam = \App\Models\FuzzyParameter::where('tipe', 'keunikan')
            ->where('label', $request->keunikan)
            ->where('is_active', true)
            ->first();

        if (!$fuzzyParam) {
            return redirect()->back()->with('error', 'Parameter keunikan tidak ditemukan.');
        }

        DsRule::create([
            'penyakit_id' => $request->penyakit_id,
            'gejala_id' => $request->gejala_id,
            'fuzzy_parameter_id' => $fuzzyParam->id,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->filled('is_active'),
        ]);

        session()->flash('success', 'Relasi gejala-penyakit berhasil ditambahkan!');
        return redirect()->route('ds-rules.index');
    }

    public function show(string $id)
    {
        $dsRule = DsRule::with(['penyakit', 'gejala', 'fuzzyParameter'])->findOrFail($id);
        // Add keunikan to response for backward compatibility
        $response = $dsRule->toArray();
        $response['keunikan'] = $dsRule->keunikan;
        return response()->json($response);
    }


    public function update(DsRuleUpdateRequest $request, string $id)
    {
        $dsRule = DsRule::findOrFail($id);

        // Get fuzzy_parameter_id from keunikan label
        $fuzzyParam = \App\Models\FuzzyParameter::where('tipe', 'keunikan')
            ->where('label', $request->keunikan)
            ->where('is_active', true)
            ->first();

        if (!$fuzzyParam) {
            return redirect()->back()->with('error', 'Parameter keunikan tidak ditemukan.');
        }

        $dsRule->update([
            'penyakit_id' => $request->penyakit_id,
            'gejala_id' => $request->gejala_id,
            'fuzzy_parameter_id' => $fuzzyParam->id,
            'deskripsi' => $request->deskripsi,
            'is_active' => $request->filled('is_active'),
        ]);

        session()->flash('success', 'Relasi gejala-penyakit berhasil diubah!');
        return redirect()->route('ds-rules.index');
    }

    public function destroy(string $id)
    {
        $dsRule = DsRule::findOrFail($id);
        $dsRule->delete();

        session()->flash('success', 'Relasi gejala-penyakit berhasil dihapus!');
        return redirect()->route('ds-rules.index');
    }
}
