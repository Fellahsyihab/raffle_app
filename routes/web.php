<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RaffleController; // Pastikan ini di-import
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. Halaman Depan Langsung Game Raffle
Route::get('/', [RaffleController::class, 'index'])->name('raffle.index');

// 2. Endpoint untuk Proses Acak Hadiah (Dipanggil AJAX/Fetch di View)
Route::post('/draw-raffle', [RaffleController::class, 'draw'])->name('raffle.draw');

// 3. Dashboard Admin (Data Peserta Pemenang)
Route::get('/dashboard', [RaffleController::class, 'adminIndex'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 4. Manajemen Hadiah (Stok Hadiah)
Route::middleware(['auth'])->group(function () {
    // Ubah URL ini agar tidak bentrok dengan dashboard
    Route::get('/admin/prizes', [AdminController::class, 'index'])->name('admin.index'); 
    
    Route::post('/admin/update/{id}', [AdminController::class, 'updateStock'])->name('admin.update');
    Route::post('/admin/add', [AdminController::class, 'store'])->name('admin.add');
    Route::delete('/admin/prizes/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
    Route::post('/admin/prizes/edit/{id}', [AdminController::class, 'editName'])->name('admin.edit.name');
    
    // Route profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // export data peserta
    Route::get('/admin/export-excel', [RaffleController::class, 'exportExcel'])->name('admin.export.excel');
    Route::get('/admin/export-pdf', [RaffleController::class, 'exportPdf'])->name('admin.export.pdf');
});

require __DIR__.'/auth.php';