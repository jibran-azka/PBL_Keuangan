<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('akun', AccountController::class)->names('akun');

    Route::resource('/transaksi', TransactionController::class)->names('transaksi');
    Route::resource('/topup', TopupController::class)->names('topup');
    Route::post('/midtrans/callback', [TopUpController::class, 'midtransCallback']);


        
    Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
    // Langkah 1 - Pilih metode
    Route::get('/tagihan/metode', [TagihanController::class, 'create'])->name('tagihan.metode');

    // Langkah 2 - Pilih tujuan bank / e-wallet
    Route::get('/tagihan/tujuan', [TagihanController::class, 'tujuan'])->name('tagihan.tujuan');

    // Langkah 3 - Form pengisian tagihan
    Route::get('/tagihan/form', [TagihanController::class, 'formTagihan'])->name('tagihan.form');

    Route::post('/tagihan/simpan', [TagihanController::class, 'simpan'])->name('tagihan.store');
    Route::get('/proses-tagihan-harian', [TagihanController::class, 'prosesTagihanHarian']);




    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/admin/user', [UserController::class, 'index'])->middleware('admin')->name('admin.user');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
