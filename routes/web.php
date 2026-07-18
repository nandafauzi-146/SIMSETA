<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicSearchController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SertifikatController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\DesaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\SettingsController;

// Public routes
Route::get('/', function () {
    return view('index');
})->name('home');

Route::post('/pencarian', [PublicSearchController::class, 'search'])->name('public.search')->middleware('throttle:30,1');

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['auth', 'verified', 'can.access.admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('sertifikat', SertifikatController::class);
        Route::patch('sertifikat/{id}/restore', [SertifikatController::class, 'restore'])->name('sertifikat.restore');
        Route::resource('pengguna', PenggunaController::class);
        Route::resource('desa', DesaController::class)->except(['show']);
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('index');
            Route::get('/pdf', [LaporanController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/excel', [LaporanController::class, 'exportExcel'])->name('export-excel');
        });

        Route::resource('sertifikat.dokumen', DokumenController::class)
            ->except(['show', 'edit', 'update', 'create']);
        Route::get('sertifikat/{sertifikat}/dokumen/{dokumen}/download', [DokumenController::class, 'download'])
            ->name('sertifikat.dokumen.download');

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingsController::class, 'index'])->name('index');
            Route::put('/', [SettingsController::class, 'update'])->name('update');
        });
    });
});
