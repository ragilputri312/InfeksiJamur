<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Illuminate\Http\Request;

class GejalaController extends Controller
{
    // Menampilkan data gejala
    public function index()
    {
        $gejala = Gejala::paginate(10); // Mengambil data gejala dengan pagination
        return view('admin.gejala.gejala', compact('gejala'));
    }

    // Menyimpan data gejala baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_gejala' => 'required|unique:tblgejala',
            'gejala' => 'required',
        ]);

        Gejala::create([
            'kode_gejala' => $request->kode_gejala,
            'gejala' => $request->gejala,
        ]);

        session()->flash('success', 'Gejala berhasil ditambahkan!');
        return redirect()->route('gejala.index');
    }

    // Mengupdate data gejala
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_gejala' => 'required',
            'gejala' => 'required',
        ]);

        $gejala = Gejala::findOrFail($id);
        $gejala->update([
            'kode_gejala' => $request->kode_gejala,
            'gejala' => $request->gejala,
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
