<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PenyakitStoreRequest;
use App\Http\Requests\PenyakitUpdateRequest;

class PenyakitController extends Controller
{
     // Menampilkan data penyakit
     public function index()
     {
         $penyakit = Penyakit::orderBy('kode_penyakit')->paginate(10); // Mengambil data penyakit dengan pagination
         return view('admin.penyakit.penyakit', compact('penyakit'));
     }

     public function show($id)
    {
        // Cari penyakit berdasarkan ID
        $penyakit = Penyakit::findOrFail($id);

        return response()->json($penyakit);
    }

     // Menyimpan data penyakit baru
     public function store(PenyakitStoreRequest $request)
     {
         Penyakit::create([
             'kode_penyakit' => $request->kode_penyakit,
             'penyakit' => $request->penyakit,
             'penangan' => $request->penangan,
         ]);

         session()->flash('success', 'Penyakit berhasil ditambahkan!');
         return redirect()->route('penyakit.index');
     }

     // Mengupdate data penyakit
     public function update(PenyakitUpdateRequest $request, $id)
     {
         $penyakit = Penyakit::findOrFail($id);
         $penyakit->update([
             'kode_penyakit' => $request->kode_penyakit,
             'penyakit' => $request->penyakit,
             'penangan' => $request->penangan,
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
