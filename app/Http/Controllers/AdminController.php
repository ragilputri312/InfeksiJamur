<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TblAkun;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\Diagnosis;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil data dari database
        $gejala = Gejala::all();
        $penyakit = Penyakit::all();
        $diagnosis = Diagnosis::all();

        // Hitung jumlah data
        $gejala_count = $gejala->count();
        $penyakit_count = $penyakit->count();
        $diagnosis_count = $diagnosis->count();

        // Kirim data ke tampilan
        return view('admin.dashboard', compact('gejala', 'penyakit', 'diagnosis', 'gejala_count', 'penyakit_count', 'diagnosis_count'));
    }

    public function create()
    {
        return view('admin.add_admin'); // sesuaikan dengan view form yang telah dibuat sebelumnya
    }

    // Method untuk menangani penyimpanan admin baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:tblakun,email',
            'sandi' => 'required|min:8',
            'alamat' => 'required|string',
            'jk' => 'required|string',
        ]);

        if ($request->sandi !== $request->password_confirmation) {
            // Kembalikan dengan error
            return back()->withErrors(['password_confirmation' => 'Kata sandi dan konfirmasi kata sandi tidak sama.'])->withInput();
        }

        // Simpan data
        $akun = new Tblakun();
        $akun->nama = $request->nama;
        $akun->email = $request->email;
        $akun->sandi = bcrypt($request->sandi);
        $akun->alamat = $request->alamat;
        $akun->jk = $request->jk;
        $akun->id_role = 1;
        $akun->save();

        // Set pesan sukses
        session()->flash('success', 'Admin berhasil ditambahkan.');

        // Redirect ke halaman lain setelah berhasil
        return redirect()->route('admin.create');
    }

    public function list()
    {
        // Ambil semua data admin dari database
        $admins = Tblakun::where('id_role', 1)->get();

        return view('admin.list_admin', compact('admins'));
    }
}
