{{-- resources/views/upt/disposisi/show.blade.php --}}
@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-layout :title="$title ?? 'Detail Pengaduan'">
    <div class="max-w-6xl mx-auto px-4 lg:px-0 py-6 space-y-6">

        {{-- CARD WRAPPER --}}
        <div class="rounded-2xl overflow-hidden shadow-lg border border-blue-200 bg-white">

            {{-- HEADER --}}
            <div class="px-6 py-5 bg-blue-600 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-xl font-semibold tracking-wide">Detail Pengaduan</h1>
                        <p class="text-xs text-blue-100 mt-1">
                            No Tiket:
                            <span class="font-semibold">{{ $item->no_tiket }}</span>
                        </p>
                    </div>

                    <a href="{{ route('layanan.pengaduan.index') }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-blue-500 hover:bg-blue-700 text-white text-sm transition">
                        ← Kembali
                    </a>
                </div>
            </div>

            {{-- BODY --}}
            <div class="px-6 py-6 space-y-8">

                {{-- INFORMASI UTAMA --}}
                <section class="p-4 rounded-xl border border-blue-100 bg-blue-50/40">
                    <h2 class="text-sm font-bold text-blue-700 uppercase mb-4 tracking-wide">Informasi Utama</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                        <div class="space-y-3">
                            <div>
                                <div class="text-blue-800/60">Pelapor</div>
                                <div class="font-medium text-blue-900">{{ $item->pelapor_nama ?? '-' }}</div>
                            </div>

                            <div>
                                <div class="text-blue-800/60">Kontak</div>
                                <div class="font-medium text-blue-900">{{ $item->pelapor_contact ?? '-' }}</div>
                            </div>

                            <div>
                                <div class="text-blue-800/60">Judul</div>
                                <div class="font-medium text-blue-900">{{ $item->judul ?? '-' }}</div>
                            </div>

                            <div>
                                <div class="text-blue-800/60">Deskripsi</div>
                                <div class="font-medium text-blue-900 whitespace-pre-line leading-relaxed">
                                    {{ $item->deskripsi ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <div class="text-blue-800/60">Status</div>

                                <span
                                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-300 mt-1">
                                    <span class="h-2 w-2 rounded-full bg-blue-600"></span>

                                    @if (trim($item->status_label ?? '') === 'Diproses oleh user layanan')
                                        Menunggu
                                    @else
                                        {{ $item->status_label }}
                                    @endif
                                </span>
                            </div>
                        </div>

                    </div>
                </section>

                {{-- BUKTI PELAPOR --}}
                <section class="p-4 rounded-xl border border-blue-100 bg-blue-50/40">
                    <h2 class="text-sm font-bold text-blue-700 uppercase mb-4 tracking-wide">Bukti Pelapor</h2>

                    @if (!empty($item->bukti_masyarakat))
                        <div class="flex flex-wrap gap-3">

                            @foreach ($item->bukti_masyarakat as $file)
                                @php
                                    $path =
                                        is_array($file) && isset($file['path'])
                                            ? $file['path']
                                            : (is_string($file)
                                                ? $file
                                                : null);
                                    $name =
                                        is_array($file) && isset($file['name']) ? $file['name'] : basename($path ?? '');
                                @endphp

                                @if ($path)
                                    <a href="{{ Storage::url($path) }}" target="_blank"
                                        class="inline-flex items-center gap-2 p-2 rounded-lg border border-blue-200 bg-white hover:border-blue-400 hover:shadow-sm transition text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3h-1.5a2 2 0 00-2 2V7" />
                                        </svg>
                                        <span class="text-blue-700">{{ $name }}</span>
                                    </a>
                                @endif
                            @endforeach

                        </div>
                    @else
                        <div class="text-sm text-blue-700/60">Tidak ada bukti terlampir.</div>
                    @endif
                </section>

                {{-- RIWAYAT --}}
                <section class="p-4 rounded-xl border border-blue-100 bg-blue-50/40">
                    <h2 class="text-sm font-bold text-blue-700 uppercase mb-4 tracking-wide">Riwayat</h2>

                    <div class="overflow-x-auto rounded-lg border border-blue-200 bg-white">
                        <table class="min-w-full text-sm">
                            <thead class="bg-blue-100">
                                <tr class="text-blue-800">
                                    <th class="px-3 py-2 border border-blue-200 text-left">Waktu</th>
                                    <th class="px-3 py-2 border border-blue-200 text-left">User</th>
                                    <th class="px-3 py-2 border border-blue-200 text-left">Aksi</th>
                                    <th class="px-3 py-2 border border-blue-200 text-left">Status Setelah</th>
                                    <th class="px-3 py-2 border border-blue-200 text-left">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($item->logs as $lg)
                                    <tr class="hover:bg-blue-50 text-blue-900">
                                        <td class="px-3 py-2 border border-blue-200 align-top">
                                            {{ $lg->created_at?->format('d M Y H:i') }}
                                        </td>

                                        <td class="px-3 py-2 border border-blue-200 align-top">
                                            {{ $lg->user?->name ?? '-' }}
                                        </td>

                                        <td class="px-3 py-2 border border-blue-200 align-top">
                                            {{ $lg->type ?? '-' }}
                                        </td>

                                        <td class="px-3 py-2 border border-blue-200 align-top">
                                            {{ str_replace('_', ' ', $lg->status_after ?? '-') }}
                                        </td>

                                        <td
                                            class="px-3 py-2 border border-blue-200 align-top whitespace-normal break-words max-w-[35ch]">
                                            {{ $lg->note ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 py-3 text-center text-blue-700/60">
                                            Belum ada riwayat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </div>

    </div>
</x-layout>
