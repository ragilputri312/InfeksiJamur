<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NilaiCF;
use App\Models\Gejala;
use App\Models\Penyakit;

class NilaiCFController extends Controller
{
    // Menampilkan data NilaiCF
    public function index()
    {
        $nilaicf = NilaiCF::paginate(10);
        $gejala = Gejala::all();
        $penyakit = Penyakit::all();
        return view('admin.nilaiCF.nilaicf', compact('nilaicf', 'gejala', 'penyakit')); // Pastikan file view ada
    }

    // Menyimpan data NilaiCF baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_gejala' => 'required|exists:tblgejala,kode_gejala', // Harus ada di tabel gejala
            'kode_penyakit' => 'required|exists:tblpenyakit,kode_penyakit', // Harus ada di tabel penyakit
            'mb' => 'required|numeric|min:0|max:1', // MB (Measure of Belief)
            'md' => 'required|numeric|min:0|max:1', // MD (Measure of Disbelief)
        ]);

        NilaiCF::create([
            'kode_gejala' => $request->kode_gejala,
            'kode_penyakit' => $request->kode_penyakit,
            'mb' => $request->mb,
            'md' => $request->md,
        ]);

        session()->flash('success', 'Nilai CF berhasil ditambahkan!');
        return redirect()->route('nilaicf.index');
    }

    // Mengupdate data NilaiCF
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_gejala' => 'required|exists:tblgejala,kode_gejala',
            'kode_penyakit' => 'required|exists:tblpenyakit,kode_penyakit',
            'mb' => 'required|numeric|min:0|max:1',
            'md' => 'required|numeric|min:0|max:1',
        ]);

        $nilaiCF = NilaiCF::findOrFail($id);
        $nilaiCF->update([
            'kode_gejala' => $request->kode_gejala,
            'kode_penyakit' => $request->kode_penyakit,
            'mb' => $request->mb,
            'md' => $request->md,
        ]);

        session()->flash('success', 'Nilai CF berhasil diubah!');
        return redirect()->route('nilaicf.index');
    }

    // Menghapus data NilaiCF
    public function destroy($id)
    {
        $nilaiCF = NilaiCF::findOrFail($id);
        $nilaiCF->delete();

        session()->flash('success', 'Nilai CF berhasil dihapus!');
        return redirect()->route('nilaicf.index');
    }
}
