<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenyakitController extends Controller
{
     // Menampilkan data penyakit
     public function index()
     {
         $penyakit = Penyakit::paginate(10); // Mengambil data penyakit dengan pagination
         return view('admin.penyakit.penyakit', compact('penyakit'));
     }

     // Menyimpan data penyakit baru
     public function store(Request $request)
     {
         $request->validate([
             'kode_penyakit' => 'required|unique:tblpenyakit',
             'penyakit' => 'required',
         ]);

         Penyakit::create([
             'kode_penyakit' => $request->kode_penyakit,
             'penyakit' => $request->penyakit,
         ]);

         session()->flash('success', 'Penyakit berhasil ditambahkan!');
         return redirect()->route('penyakit.index');
     }

     // Mengupdate data penyakit
     public function update(Request $request, $id)
     {
         $request->validate([
             'kode_penyakit' => 'required',
             'penyakit' => 'required',
         ]);

         $penyakit = Penyakit::findOrFail($id);
         $penyakit->update([
             'kode_penyakit' => $request->kode_penyakit,
             'penyakit' => $request->penyakit,
         ]);

         session()->flash('success', 'Penyakit berhasil diubah!');
         return redirect()->route('penyakit.index');
     }

     // Menghapus data penyakit
     public function destroy($id)
     {
         $penyakit = Penyakit::findOrFail($id);
         $penyakit->delete();

         session()->flash('success', 'Penyakit berhasil dihapus!');
         return redirect()->route('penyakit.index');
     }
}
