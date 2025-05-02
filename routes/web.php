<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\SettingUjianController;
use App\Http\Controllers\JadwalUjianController;
use App\Http\Controllers\BankSoalController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin 
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');


    Route::get('/kelas/index', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
    Route::get('/kelas/{kode_kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('/kelas/{kode_kelas}/update', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{kode_kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    Route::post('/kelas/import', [KelasController::class, 'import'])->name('kelas.import');

    //Daftar Siswa
    Route::get('/siswa/index', [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id_siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id_siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id_siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::get('/siswa/cetak-kartu', [SiswaController::class, 'cetakKartu'])->name('siswa.cetak-kartu');

    Route::get('/mapel/index', [MataPelajaranController::class, 'index'])->name('mapel.index');
    Route::post('/mapel/store', [MataPelajaranController::class, 'store'])->name('mapel.store');
    Route::get('/mapel/{kode_mapel}/edit', [MataPelajaranController::class, 'edit'])->name('mapel.edit');
    Route::put('/mapel/{kode_mapel}', [MataPelajaranController::class, 'update'])->name('mapel.update');
    Route::delete('/mapel/{kode_mapel}', [MataPelajaranController::class, 'destroy'])->name('mapel.destroy');

    Route::get('/setting-ujian/index', [SettingUjianController::class, 'index'])->name('setting-ujian.index');

    Route::get('/jadwal-ujian/index', [JadwalUjianController::class, 'index'])->name('jadwal-ujian.index');

    Route::get('/bank-soal/index', [BankSoalController::class, 'index'])->name('bank-soal.index');
});

// Siswa 
Route::middleware('siswa')->group(function () {
    Route::get('/siswa/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');
});