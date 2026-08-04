<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ZakatController extends Controller
{
    /**
     * User Dashboard Overview
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $totalPaid = Payment::where('user_id', $user->id)
            ->whereIn('status', ['Diverifikasi', 'Sudah Disalurkan'])
            ->sum('amount');

        $pendingCount = Payment::where('user_id', $user->id)
            ->where('status', 'Menunggu Verifikasi')
            ->count();

        $verifiedCount = Payment::where('user_id', $user->id)
            ->where('status', 'Diverifikasi')
            ->count();

        $distributedCount = Payment::where('user_id', $user->id)
            ->where('status', 'Sudah Disalurkan')
            ->count();

        $recentPayments = Payment::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'totalPaid',
            'pendingCount',
            'verifiedCount',
            'distributedCount',
            'recentPayments'
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

        return view('zakat.pay', compact('user', 'qrisUrl', 'prefilledAmount', 'prefilledTitle'));
    }

    /**
     * Store Payment Upload
     */
    public function storePay(Request $request)
    {
        $request->validate([
            'sender_name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1000'],
            'proof_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'], // max 5MB
        ], [
            'sender_name.required' => 'Nama pengirim wajib diisi.',
            'title.required' => 'Judul / Peruntukan zakat wajib dipilih.',
            'amount.required' => 'Nominal zakat wajib diisi.',
            'amount.min' => 'Nominal zakat minimal Rp 1.000.',
            'proof_image.required' => 'Bukti pembayaran wajib diunggah.',
            'proof_image.image' => 'File bukti pembayaran harus berupa gambar (JPG, PNG).',
            'proof_image.max' => 'Ukuran gambar maksimal adalah 5 MB.',
        ]);

        $path = $request->file('proof_image')->store('payment_proofs', 'public');

        Payment::create([
            'user_id' => Auth::id(),
            'sender_name' => $request->sender_name,
            'title' => $request->title,
            'amount' => $request->amount,
            'proof_image' => $path,
            'status' => 'Menunggu Verifikasi',
        ]);

        return redirect()->route('zakat.history')->with('success', 'Bukti pembayaran berhasil dikirim! Status Anda saat ini Menunggu Verifikasi.');
    }

    /**
     * Payment History View
     */
    public function history(Request $request)
    {
        $user = Auth::user();
        $statusFilter = $request->query('status');

        $query = Payment::where('user_id', $user->id);

        if ($statusFilter && in_array($statusFilter, ['Menunggu Verifikasi', 'Diverifikasi', 'Sudah Disalurkan', 'Ditolak'])) {
            $query->where('status', $statusFilter);
        }

        $payments = $query->latest()->paginate(10)->withQueryString();

        return view('zakat.history', compact('payments', 'statusFilter'));
    }

    /**
     * Download or View Receipt Struk
     */
    public function receipt(Payment $payment)
    {
        if ($payment->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Akses tidak diizinkan');
        }

        return view('zakat.receipt', compact('payment'));
    }
}
