<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Middleware\CheckLogin;
use App\Models\Gejala;
use App\Models\IntervalCF;

Route::get('/', [LandingController::class, 'index'])->name('landing');

// Terapkan middleware langsung pada route
Route::get('/form-diagnosa', function () {
    return view('form_diagnosa');
})->middleware(CheckLogin::class);

Route::get('/form', function () {
    $data = [
        'gejala' => Gejala::all(),
        'nilai_interval' => IntervalCF::all()
    ];

    return view('form', $data);
})->middleware(CheckLogin::class);

// Route::get('/result', function () {
//     return view('clients.cl_diagnosa_result');
// })->middleware(CheckLogin::class);

Route::resource('diagnosis', DiagnosisController::class);
Route::get('/diagnosis/result/{diagnosis_id}', [DiagnosisController::class, 'diagnosisResult'])->name('diagnosis.result');

Route::resource('user', UserController::class);
Route::get('login', [UserController::class, 'showlogin'])->name('user.showlogin');
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get('/registration', [UserController::class, 'registration'])->name('user.registration');

//admin
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard')->middleware(CheckLogin::class);

// Route untuk menampilkan daftar admin
Route::get('/dashboard/list', [AdminController::class, 'list'])->name('admin.list');

// Route untuk form tambah admin
Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');

// Route untuk menyimpan data admin
Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');


Route::get('/home', function () {
    return redirect('/dashboard');
});

Route::resource('gejala', GejalaController::class);
Route::put('/gejala/{id}', [GejalaController::class, 'update'])->name('gejala.update');

Route::resource('penyakit', PenyakitController::class);
Route::put('/penyakit/{id}', [PenyakitController::class, 'update'])->name('penyakit.update');

Route::get('/dashboard/hasildiagnosa', function () {
    return view('admin.diagnosa.hasil_diagnosa');
});
