<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TblAkun;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Periksa apakah user sudah login
        if (session()->has('user_id')) {
            // Ambil informasi user dari session
            $user_id = session('user_id');
            $user_name = session('user_name');
            $user_role = session('user_role');

            // Kirim data ke view landing page
            return view('landing', compact('user_id','user_name', 'user_role'));
        }

        // Jika belum login, kirim data kosong
        return view('landing');
    }

    public function showlogin()
    {
        return view('login'); // sesuaikan dengan view form yang telah dibuat sebelumnya
    }
    public function registration()
    {
        return view('registration'); // sesuaikan dengan view form yang telah dibuat sebelumnya
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'telepon' => 'required|string',
            'sandi' => 'required|min:8',
        ]);

        // Cari pengguna berdasarkan nomor telepon
        $akun = Tblakun::where('telepon', $request->telepon)->first();

        if ($akun && password_verify($request->sandi, $akun->sandi)) {
            // Simpan data pengguna ke session
            session([
                'user_id' => $akun->id_akun,
                'user_name' => $akun->nama,
                'user_role' => $akun->id_role,
            ]);

            $redirectUrl = session('redirect_url', '/');
            session()->forget('redirect_url');

            // Periksa id_role untuk menentukan redirect
            if ($akun->id_role == 1) {
                // Redirect ke dashboard
                return redirect()->route('dashboard')->with('success', 'Login berhasil sebagai Admin!');
            } elseif ($akun->id_role == 2) {
                // Redirect ke landing
                return redirect($redirectUrl)->with('success', 'Login berhasil sebagai User!');
            }

            // Jika id_role tidak dikenali (opsional)
            return redirect()->route('landing')->with('error', 'Role tidak dikenali.');
        }

        // Jika gagal login
        return back()->withErrors(['login' => 'Nomor telepon atau kata sandi salah.'])->withInput();
    }



    public function logout(Request $request)
{
    // Hapus session
    $request->session()->flush();

    // Redirect ke halaman login
    return redirect()->route('user.showlogin')->with('success', 'Logout berhasil.');
}


    // Method untuk menangani penyimpanan user baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20|unique:tblakun,telepon',
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
        $akun->telepon = $request->telepon;
        $akun->sandi = bcrypt($request->sandi);
        $akun->alamat = $request->alamat;
        $akun->jk = $request->jk;
        $akun->id_role = 2;
        $akun->save();

        // Set pesan sukses
        session()->flash('success', 'Registrasi berhasil! Silakan login.');

        // Redirect ke halaman lain setelah berhasil
        return redirect()->route('user.showlogin');
    }
}
