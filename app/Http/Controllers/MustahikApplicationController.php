<?php

namespace App\Http\Controllers;

use App\Models\MustahikApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MustahikApplicationController extends Controller
{
    public function apply()
    {
        return view('mustahik.apply');
    }

    public function storeApply(Request $request)
    {
        $validated = $request->validate([
            'applicant_name' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'asnaf_category' => 'required|string|in:Fakir,Miskin,Amil,Muallaf,Riqab,Gharim,Fisabilillah,Ibnu Sabil',
            'program_type' => 'required|string',
            'amount_requested' => 'required|numeric|min:10000',
            'reason' => 'required|string|min:20',
            'sktm_proof_image' => 'required|image|mimes:jpeg,png,jpg,pdf|max:5120',
        ], [
            'applicant_name.required' => 'Nama lengkap pemohon wajib diisi.',
            'nik.required' => 'NIK KTP 16 digit wajib diisi.',
            'nik.size' => 'NIK KTP harus tepat 16 digit angka.',
            'phone.required' => 'Nomor HP/WhatsApp aktif wajib diisi.',
            'address.required' => 'Alamat domisili lengkap wajib diisi.',
            'asnaf_category.required' => 'Kategori Asnaf wajib dipilih.',
            'amount_requested.required' => 'Nominal pengajuan bantuan wajib diisi.',
            'reason.required' => 'Alasan permohonan bantuan wajib dijelaskan.',
            'reason.min' => 'Penjelasan alasan permohonan minimal 20 karakter.',
            'sktm_proof_image.required' => 'Berkas bukti (KTP / SKTM / Berkas Pendukung) wajib diunggah.',
            'sktm_proof_image.image' => 'Berkas pendukung harus berupa gambar (JPG/PNG).',
        ]);

        $proofPath = null;
        if ($request->hasFile('sktm_proof_image')) {
            $proofPath = $request->file('sktm_proof_image')->store('sktm_proofs', 'public');
        }

        MustahikApplication::create([
            'user_id' => Auth::id(),
            'applicant_name' => $validated['applicant_name'],
            'nik' => $validated['nik'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'asnaf_category' => $validated['asnaf_category'],
            'program_type' => $validated['program_type'],
            'amount_requested' => $validated['amount_requested'],
            'reason' => $validated['reason'],
            'sktm_proof_image' => $proofPath,
            'status' => 'Menunggu Verifikasi',
        ]);

        return redirect()->route('mustahik.my_applications')
            ->with('success', 'Permohonan bantuan zakat Anda telah berhasil diajukan dan sedang dalam proses verifikasi oleh Tim Amil Baitul Maal.');
    }

    public function myApplications()
    {
        $applications = MustahikApplication::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('mustahik.index', compact('applications'));
    }
}
