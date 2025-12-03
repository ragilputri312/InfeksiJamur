<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;
use App\Http\Requests\GejalaStoreRequest;
use App\Http\Requests\GejalaUpdateRequest;

class GejalaController extends Controller
{
    // Menampilkan data gejala
    public function index()
    {
        $gejala = Gejala::orderBy('created_at', 'desc')->paginate(10); // Mengambil data gejala dengan pagination, diurutkan berdasarkan yang terakhir dibuat
        return view('admin.gejala.gejala', compact('gejala'));
    }

    // Menyimpan data gejala baru
    public function store(GejalaStoreRequest $request)
    {
        Gejala::create([
            'kode_gejala' => $request->kode_gejala,
            'gejala' => $request->gejala,
            'pertanyaan' => $request->pertanyaan,
            'is_active' => (bool)($request->is_active ?? true),
            'urutan' => $request->urutan,
        ]);

        session()->flash('success', 'Gejala berhasil ditambahkan!');
        return redirect()->route('gejala.index');
    }

    // Mengupdate data gejala
    public function update(GejalaUpdateRequest $request, $id)
    {
        $gejala = Gejala::findOrFail($id);
        $gejala->update([
            'kode_gejala' => $request->kode_gejala,
            'gejala' => $request->gejala,
            'pertanyaan' => $request->pertanyaan,
            'is_active' => (bool)($request->is_active ?? $gejala->is_active),
            'urutan' => $request->urutan,
        ]);

        session()->flash('success', 'Gejala berhasil diubah!');
        return redirect()->route('gejala.index');
    }

    // Menghapus data gejala
    public function destroy($id)
    {
        $gejala = Gejala::findOrFail($id);
        $gejala->delete();

        session()->flash('success', 'Gejala berhasil dihapus!');
        return redirect()->route('gejala.index');
    }
}
