<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SppController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\PembayaranController as PetugasPembayaranController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\HistoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return redirect()->route('login')->with('status', 'Anda harus login terlebih dahulu');
});

// Dashboard redirect
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Profile routes
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Admin Routes - tanpa middleware auth
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class);
    Route::resource('/kelas', KelasController::class);
    Route::resource('/spp', SppController::class);
    Route::resource('/siswa', SiswaController::class);
    Route::get('/siswa/{siswa}/payment-history', [SiswaController::class, 'paymentHistory'])->name('siswa.paymentHistory');
    Route::resource('/pembayaran', AdminPembayaranController::class);
    Route::get('/laporan', [AdminPembayaranController::class, 'generateReport'])->name('laporan');
    Route::get('/api/pembayaran/bulan-sudah-dibayar', [AdminPembayaranController::class, 'bulanSudahDibayar']);
});

// Petugas Routes - tanpa middleware auth
Route::prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/pembayaran', PetugasPembayaranController::class);
    Route::get('/laporan', [PetugasPembayaranController::class, 'generateReport'])->name('laporan');

    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [App\Http\Controllers\Petugas\SiswaController::class, 'index'])->name('index');
        Route::get('/{siswa}/payment-history', [App\Http\Controllers\Petugas\SiswaController::class, 'paymentHistory'])->name('paymentHistory');
    });
});

// Siswa Routes - tanpa middleware auth
Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/history', HistoryController::class)->only(['index', 'show']);
});

// Routes untuk laporan
Route::prefix('reports')->group(function () {
    Route::get('/', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/custom', [App\Http\Controllers\ReportController::class, 'customReport'])->name('reports.custom');
});

require __DIR__ . '/auth.php';
