<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Riwayat Permohonan Bantuan Mustahik') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-200 p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-200">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Daftar Pengajuan Bantuan Saya</h3>
                        <p class="text-xs text-slate-500">Pantau status verifikasi dan penyaluran permohonan zakat Anda secara real-time.</p>
                    </div>
                    <a href="{{ route('mustahik.apply') }}" class="px-4 py-2.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm transition-colors flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Buat Pengajuan Baru</span>
                    </a>
                </div>

                @if($applications->isEmpty())
                    <div class="text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-300">
                        <div class="w-12 h-12 rounded-xl overflow-hidden border border-slate-300 mx-auto mb-3 flex items-center justify-center">
                            <img src="{{ asset('storage/baitul_mal.jpg') }}" class="w-full h-full object-cover" alt="Baitul Maal Logo" />
                        </div>
                        <h4 class="text-base font-bold text-slate-800">Belum Ada Pengajuan Bantuan</h4>
                        <p class="text-xs text-slate-500 mt-1 mb-4">Anda belum pernah mengajukan permohonan bantuan zakat.</p>
                        <a href="{{ route('mustahik.apply') }}" class="inline-flex items-center px-4 py-2 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition-colors">
                            Ajukan Permohonan Sekarang
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100 text-slate-700 uppercase font-bold text-[10px] border-b border-slate-200">
                                    <th class="p-3">Tanggal</th>
                                    <th class="p-3">Program Bantuan</th>
                                    <th class="p-3">Asnaf</th>
                                    <th class="p-3 text-right">Nominal Pengajuan</th>
                                    <th class="p-3 text-center">Status</th>
                                    <th class="p-3">Keterangan Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 font-medium">
                                @foreach($applications as $app)
                                    <tr class="hover:bg-slate-50">
                                        <td class="p-3 text-slate-600 whitespace-nowrap">{{ $app->created_at->translatedFormat('d M Y, H:i') }}</td>
                                        <td class="p-3 text-slate-900 font-bold">
                                            {{ $app->program_type }}
                                            <p class="text-[10px] text-slate-500 font-normal truncate max-w-xs">{{ $app->reason }}</p>
                                        </td>
                                        <td class="p-3">
                                            <span class="inline-block px-2.5 py-1 text-[10px] font-bold rounded-md bg-slate-100 text-slate-700 border border-slate-300">
                                                {{ $app->asnaf_category }}
                                            </span>
                                        </td>
                                        <td class="p-3 text-right font-extrabold text-emerald-700 whitespace-nowrap">
                                            Rp {{ number_format($app->amount_requested, 0, ',', '.') }}
                                        </td>
                                        <td class="p-3 text-center whitespace-nowrap">
                                            @if($app->status === 'Menunggu Verifikasi')
                                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-300">
                                                    🟡 Menunggu Verifikasi
                                                </span>
                                            @elseif($app->status === 'Disetujui')
                                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                    🟢 Disetujui Amil
                                                </span>
                                            @elseif($app->status === 'Telah Disalurkan')
                                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-blue-100 text-blue-800 border border-blue-300">
                                                    🔵 Telah Disalurkan
                                                </span>
                                            @elseif($app->status === 'Ditolak')
                                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-rose-100 text-rose-800 border border-rose-300">
                                                    🔴 Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-3 text-slate-600">
                                            @if($app->status === 'Ditolak')
                                                <p class="text-rose-600 font-semibold">Alasan: {{ $app->rejection_reason ?? '-' }}</p>
                                            @elseif($app->verified_at)
                                                <p class="text-slate-500 text-[10px]">Diverifikasi: {{ $app->verified_at->translatedFormat('d M Y') }}</p>
                                            @else
                                                <p class="text-slate-400 italic">Sedang ditinjau oleh Amil Zakat</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $applications->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
