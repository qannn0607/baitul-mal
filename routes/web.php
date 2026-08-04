<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZakatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // User Dashboard
    Route::get('/dashboard', [ZakatController::class, 'dashboard'])->name('dashboard');

    // Kalkulator Zakat
    Route::get('/hitung-zakat', [ZakatController::class, 'calculator'])->name('zakat.calculator');

    // Pembayaran Zakat (QRIS)
    Route::get('/bayar-zakat', [ZakatController::class, 'pay'])->name('zakat.pay');
    Route::post('/bayar-zakat', [ZakatController::class, 'storePay'])->name('zakat.pay.store');

    // Riwayat Pembayaran & Struk
    Route::get('/riwayat-pembayaran', [ZakatController::class, 'history'])->name('zakat.history');
    Route::get('/struk/{payment}', [ZakatController::class, 'receipt'])->name('zakat.receipt');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
