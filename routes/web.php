<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\NilaiCFController;
use App\Http\Middleware\CheckLogin;
use App\Models\Gejala;
use App\Models\IntervalCF;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('login', [UserController::class, 'showlogin'])->name('user.showlogin');
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get('/registration', [UserController::class, 'registration'])->name('user.registration');

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

Route::get('/result', function () {
    return view('clients.cl_diagnosa_result');
})->middleware(CheckLogin::class);

Route::resource('diagnosis', DiagnosisController::class)->middleware(CheckLogin::class);
Route::get('/diagnosis/result/{diagnosis_id}', [DiagnosisController::class, 'diagnosisResult'])->name('diagnosis.result')->middleware(CheckLogin::class);
Route::get('/hasil_diagnosis', [DiagnosisController::class, 'indexAdmin'])->name('diagnosis.indexAdmin')->middleware(CheckLogin::class);
Route::get('/getDiagnosisData/{diagnosis_id}', [DiagnosisController::class, 'getDiagnosisData'])->middleware(CheckLogin::class);

Route::resource('user', UserController::class)->middleware(CheckLogin::class);
//admin
Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard')->middleware(CheckLogin::class);

// Route untuk menampilkan daftar admin
Route::get('/admin_list', [AdminController::class, 'list'])->name('admin.list')->middleware(CheckLogin::class);

// Route untuk form tambah admin
Route::get('/admin_create', [AdminController::class, 'create'])->name('admin.create')->middleware(CheckLogin::class);

// Route untuk menyimpan data admin
Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store')->middleware(CheckLogin::class);


Route::get('/home', function () {
    return redirect('/dashboard');
})->middleware(CheckLogin::class);

Route::resource('gejala', GejalaController::class)->middleware(CheckLogin::class);
Route::put('/gejala/{id}', [GejalaController::class, 'update'])->name('gejala.update')->middleware(CheckLogin::class);

Route::resource('penyakit', PenyakitController::class)->middleware(CheckLogin::class);
Route::put('/penyakit/{id}', [PenyakitController::class, 'update'])->name('penyakit.update')->middleware(CheckLogin::class);
Route::get('/penyakit/{id}', [PenyakitController::class, 'show'])->name('penyakit.show')->middleware(CheckLogin::class);

Route::resource('nilaicf', NilaiCFController::class)->middleware(CheckLogin::class);
Route::put('/nilaicf/{id}', [NilaiCFController::class, 'update'])->name('nilaicf.update')->middleware(CheckLogin::class);
