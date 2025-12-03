<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\NilaiCFController;
use App\Http\Controllers\DsRuleController;
use App\Http\Controllers\DsDiagnosisController;
use App\Http\Controllers\FuzzyCategoryController;
use App\Http\Controllers\FuzzyRuleController;
use App\Http\Middleware\CheckLogin;
use App\Models\Gejala;
use App\Models\IntervalCF;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('login', [UserController::class, 'showlogin'])->name('user.showlogin');
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get('/registration', [UserController::class, 'registration'])->name('user.registration');
Route::resource('user', UserController::class);

// DS Diagnosis Routes (replacing CF diagnosis)
Route::get('/form-diagnosis', [DsDiagnosisController::class, 'index'])->name('form-diagnosis')->middleware(CheckLogin::class);
Route::get('/form-faq', [DsDiagnosisController::class, 'faqIndex'])->name('form-faq')->middleware(CheckLogin::class);
Route::get('/result', function () {
    return redirect()->route('ds-diagnosis.index');
})->middleware(CheckLogin::class);


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

// CF routes removed - using DS diagnosis instead

Route::resource('ds-rules', DsRuleController::class)->except(['create', 'edit'])->middleware(CheckLogin::class);

// Fuzzy Categories Routes
Route::resource('fuzzy-categories', FuzzyCategoryController::class)->except(['create', 'edit', 'show'])->middleware(CheckLogin::class);

// Fuzzy Parameters Routes (Kemunculan & Keunikan)
Route::get('/fuzzy-parameters', [App\Http\Controllers\FuzzyParameterController::class, 'index'])->name('fuzzy-parameters.index')->middleware(CheckLogin::class);
Route::post('/fuzzy-parameters', [App\Http\Controllers\FuzzyParameterController::class, 'store'])->name('fuzzy-parameters.store')->middleware(CheckLogin::class);
Route::put('/fuzzy-parameters/{id}', [App\Http\Controllers\FuzzyParameterController::class, 'update'])->name('fuzzy-parameters.update')->middleware(CheckLogin::class);
Route::delete('/fuzzy-parameters/{id}', [App\Http\Controllers\FuzzyParameterController::class, 'destroy'])->name('fuzzy-parameters.destroy')->middleware(CheckLogin::class);

// DS Diagnosis Routes
Route::get('/ds-diagnosis', [DsDiagnosisController::class, 'index'])->name('ds-diagnosis.index')->middleware(CheckLogin::class);
Route::post('/ds-diagnosis/process', [DsDiagnosisController::class, 'process'])->name('ds-diagnosis.process')->middleware(CheckLogin::class);
Route::get('/ds-diagnosis/result/{id}', [DsDiagnosisController::class, 'result'])->name('ds-diagnosis.result')->middleware(CheckLogin::class);

// Client Diagnosis History Routes
Route::get('/riwayat-diagnosis', [DsDiagnosisController::class, 'clientHistory'])->name('client.diagnosis.history')->middleware(CheckLogin::class);
Route::get('/riwayat-diagnosis/{id}', [DsDiagnosisController::class, 'clientHistoryDetail'])->name('client.diagnosis.detail')->middleware(CheckLogin::class);

// Admin DS Diagnosis Routes
Route::get('/admin/ds-diagnosis', [DsDiagnosisController::class, 'adminIndex'])->name('admin.ds-diagnosis.index')->middleware(CheckLogin::class);
Route::get('/admin/ds-diagnosis/{id}', [DsDiagnosisController::class, 'adminShow'])->name('admin.ds-diagnosis.show')->middleware(CheckLogin::class);

// Fuzzy Rules Routes
Route::get('/admin/fuzzy-rules', [FuzzyRuleController::class, 'index'])->name('admin.fuzzy-rules.index')->middleware(CheckLogin::class);
Route::get('/admin/fuzzy-rules/explanation', [FuzzyRuleController::class, 'explanation'])->name('admin.fuzzy-rules.explanation')->middleware(CheckLogin::class);

