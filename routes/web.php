<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

// Redirect root ke dashboard
Route::get('/', fn () => redirect()->route('dashboard'));

// Auth routes (hanya login, bukan register)
require __DIR__.'/auth.php';

// Semua route dilindungi middleware auth
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Driver
    Route::get('/drivers',         [DriverController::class, 'index'])->name('drivers.index');
    Route::get('/drivers/tambah',  [DriverController::class, 'create'])->name('drivers.create');
    Route::post('/drivers',        [DriverController::class, 'store'])->name('drivers.store');
    Route::get('/drivers/{driver}',[DriverController::class, 'show'])->name('drivers.show');

    // Rekap
    Route::get('/rekap/bulanan', [RekapController::class, 'bulanan'])->name('rekap.bulanan');
    Route::get('/rekap/tahunan', [RekapController::class, 'tahunan'])->name('rekap.tahunan');

    // Export
    Route::get('/export',          [ExportController::class, 'index'])->name('export.index');
    Route::post('/export/download',[ExportController::class, 'download'])->name('export.download');

});
