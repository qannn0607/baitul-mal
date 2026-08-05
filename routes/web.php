<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ZakatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
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
    Route::get('/riwayat-pembayaran/check/{payment}', [ZakatController::class, 'checkStatus'])->name('zakat.check');
    Route::get('/struk/{payment}', [ZakatController::class, 'receipt'])->name('zakat.receipt');

    // Cetak Laporan Keuangan PDF
    Route::get('/reports/financial/print', [\App\Http\Controllers\ExportReportController::class, 'financialReport'])->name('reports.financial.print');

    // Pengajuan Bantuan Mustahik
    Route::get('/mustahik/apply', [\App\Http\Controllers\MustahikApplicationController::class, 'apply'])->name('mustahik.apply');
    Route::post('/mustahik/apply', [\App\Http\Controllers\MustahikApplicationController::class, 'storeApply'])->name('mustahik.apply.store');
    Route::get('/mustahik/my-applications', [\App\Http\Controllers\MustahikApplicationController::class, 'myApplications'])->name('mustahik.my_applications');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Callback Notification Midtrans (bebas CSRF)
Route::post('/api/midtrans/notification', [\App\Http\Controllers\Api\PaymentCallbackController::class, 'handleNotification'])->name('midtrans.callback');

require __DIR__.'/auth.php';
