<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
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

}
