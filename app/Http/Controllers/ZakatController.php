<?php

namespace App\Http\Controllers;

use App\Models\Distribution;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZakatController extends Controller
{
    /**
     * User Dashboard Overview
     */
    public function dashboard()
    {
        $user = Auth::user();

        $totalPaid = Payment::where('user_id', $user->id)
            ->whereIn('status', ['Transaksi Sukses', 'Sudah Disalurkan'])
            ->sum('amount');

        $pendingCount = Payment::where('user_id', $user->id)
            ->where('status', 'Menunggu Verifikasi')
            ->count();

        $verifiedCount = Payment::where('user_id', $user->id)
            ->where('status', 'Transaksi Sukses')
            ->count();

        $distributedCount = Payment::where('user_id', $user->id)
            ->where('status', 'Sudah Disalurkan')
            ->count();

        $recentPayments = Payment::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Transparency & Distribution Stats (Global 8 Asnaf)
        $totalCollectedGlobal = Payment::whereIn('status', ['Transaksi Sukses', 'Sudah Disalurkan'])->sum('amount');
        $totalDistributedGlobal = Distribution::sum('amount');
        $remainingBalanceGlobal = max(0, $totalCollectedGlobal - $totalDistributedGlobal);

        $asnafList = ['Fakir', 'Miskin', 'Amil', 'Muallaf', 'Riqab', 'Gharim', 'Fisabilillah', 'Ibnu Sabil'];
        $asnafBreakdown = [];
        foreach ($asnafList as $asnafName) {
            $asnafBreakdown[$asnafName] = Distribution::where('asnaf', $asnafName)->sum('amount');
        }

        $recentDistributions = Distribution::with('amil')->latest('distribution_date')->take(5)->get();

        return view('dashboard', compact(
            'user',
            'totalPaid',
            'pendingCount',
            'verifiedCount',
            'distributedCount',
            'recentPayments',
            'totalCollectedGlobal',
            'totalDistributedGlobal',
            'remainingBalanceGlobal',
            'asnafBreakdown',
            'recentDistributions'
        ));
    }

    /**
     * Zakat Calculator View
     */
    public function calculator()
    {
        $setting = Setting::first();
        $nisabGoldPrice = $setting ? $setting->nisab_gold_price : 1400000;

        // Nisab Maal = 85 gram gold
        $nisabMaalYearly = 85 * $nisabGoldPrice;
        // Nisab Penghasilan Monthly = 85 gram / 12 * gold price
        $nisabPenghasilanMonthly = round((85 * $nisabGoldPrice) / 12);

        return view('zakat.calculator', compact(
            'nisabGoldPrice',
            'nisabMaalYearly',
            'nisabPenghasilanMonthly'
        ));
    }

    /**
     * Bayar Zakat View
     */
    public function pay(Request $request)
    {
        $user = Auth::user();
        $qrisUrl = Setting::getQrisUrl();
        $prefilledAmount = $request->query('amount', '');
        $prefilledTitle = $request->query('title', 'Zakat Maal');
        $clientKey = config('services.midtrans.client_key');
        $isProduction = config('services.midtrans.is_production');

        return view('zakat.pay', compact('user', 'qrisUrl', 'prefilledAmount', 'prefilledTitle', 'clientKey', 'isProduction'));
    }

    /**
     * Store Payment (Manual Upload or Midtrans Online)
     */
    public function storePay(Request $request)
    {
        $request->validate([
            'sender_name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'proof_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'], // max 5MB
            'payment_method' => ['nullable', 'string'],
        ], [
            'sender_name.required' => 'Nama pengirim wajib diisi.',
            'title.required' => 'Judul / Peruntukan zakat wajib dipilih.',
            'amount.required' => 'Nominal zakat wajib diisi.',
            'amount.min' => 'Nominal zakat minimal Rp 1.000.',
            'proof_image.image' => 'File bukti pembayaran harus berupa gambar (JPG, PNG).',
            'proof_image.max' => 'Ukuran gambar maksimal adalah 5 MB.',
        ]);

        $path = null;
        if ($request->hasFile('proof_image')) {
            $path = $request->file('proof_image')->store('payment_proofs', 'public');
        }

        $payment = Payment::create([
            'user_id' => Auth::id(),
            'sender_name' => $request->sender_name,
            'title' => $request->title,
            'amount' => $request->amount,
            'proof_image' => $path,
            'notes' => $request->notes,
            'status' => 'Menunggu Verifikasi',
        ]);

        // If Midtrans payment or no manual proof uploaded, generate Snap Token
        $snapToken = MidtransService::createSnapToken($payment);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'payment_id' => $payment->id,
                'snap_token' => $snapToken,
                'redirect_url' => route('zakat.history'),
            ]);
        }

        if ($snapToken && ! $path) {
            return redirect()->route('zakat.history', ['snap_token' => $snapToken, 'payment_id' => $payment->id])
                ->with('success', 'Transaksi zakat berhasil dibuat! Silakan selesaikan pembayaran via Midtrans.');
        }

        return redirect()->route('zakat.history')->with('success', 'Bukti pembayaran berhasil dikirim! Status Anda saat ini Menunggu Verifikasi.');
    }

    /**
     * Payment History View
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $statusFilter = $request->query('status');
        $activeSnapToken = $request->query('snap_token');
        $activePaymentId = $request->query('payment_id');

        // Auto-sync any pending Midtrans payments for this user
        $pendingPayments = Payment::where('user_id', $user->id)
            ->where('status', 'Menunggu Verifikasi')
            ->whereNotNull('midtrans_order_id')
            ->get();

        foreach ($pendingPayments as $p) {
            MidtransService::syncPaymentStatus($p);
        }

        $query = Payment::where('user_id', $user->id);

        if ($statusFilter && in_array($statusFilter, ['Menunggu Verifikasi', 'Transaksi Sukses', 'Sudah Disalurkan', 'Ditolak'])) {
            $query->where('status', $statusFilter);
        }

        $payments = $query->latest()->paginate(10)->withQueryString();
        $clientKey = config('services.midtrans.client_key');
        $isProduction = config('services.midtrans.is_production');

        return view('zakat.history', compact('payments', 'statusFilter', 'activeSnapToken', 'activePaymentId', 'clientKey', 'isProduction'));
    }

    /**
     * Check status with Midtrans API directly
     */
    public function checkStatus(Payment $payment)
    {
        if ($payment->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            abort(403, 'Akses tidak diizinkan');
        }

        $synced = MidtransService::syncPaymentStatus($payment);

        if ($synced && $payment->fresh()->status === 'Transaksi Sukses') {
            return redirect()->route('zakat.history')->with('success', 'Status pembayaran berhasil diverifikasi: Transaksi Sukses!');
        }

        return redirect()->route('zakat.history')->with('info', 'Status pembayaran saat ini: ' . $payment->fresh()->status);
    }

    /**
     * Download or View Receipt Struk
     */
    public function receipt(Payment $payment)
    {
        if ($payment->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            abort(403, 'Akses tidak diizinkan');
        }

        return view('zakat.receipt', compact('payment'));
    }
}
