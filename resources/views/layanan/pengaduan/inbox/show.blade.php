{{-- resources/views/upt/disposisi/show.blade.php --}}
@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-layout :title="$title ?? 'Detail Pengaduan'">
    <div class="max-w-6xl mx-auto px-4 lg:px-0 py-6 space-y-6">

        {{-- Header --}}
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h1 class="text-lg font-semibold">Detail Pengaduan</h1>
                        <p class="text-xs text-indigo-100/90">
                            No Tiket: <span class="font-semibold">{{ $item->no_tiket }}</span>
                        </p>
                    </div>
                    <a href="{{ route('layanan.pengaduan.inbox.index') }}"
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-white/10 text-white hover:bg-white/20 text-sm">
                        ← Kembali
                    </a>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5 space-y-8">

                {{-- Meta dua kolom left aligned --}}
                <section>
                    <h2 class="text-base font-semibold text-slate-800 mb-3">Informasi Utama</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                        <div class="space-y-3">
                            <div>
                                <div class="text-slate-500">Pelapor</div>
                                <div class="font-medium">{{ $item->pelapor_nama ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500">Kontak</div>
                                <div class="font-medium">{{ $item->pelapor_contact ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500">Judul</div>
                                <div class="font-medium">{{ $item->judul ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="text-slate-500">Deskripsi</div>
                                <div class="font-medium leading-relaxed whitespace-pre-line">
                                    {{ $item->deskripsi ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <div class="text-slate-500">Status</div>
                                <span
                                    class="inline-flex items-center gap-1.5 px-2 py-0.5 text-xs font-medium rounded-full border  bg-amber-50 text-amber-700 border-amber-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-current/60"></span>
                                    {{-- {{ $item->status_label }} --}}
                                    @if ($item->status_label === 'Diproses oleh user layanan ')
                                        Menunggu
                                    @else
                                        {{ $item->status_label }}
                                    @endif

                                </span>
                            </div>

                            {{-- <div>
                                <div class="text-slate-500">Admin UPT</div>
                                <div class="font-medium">{{ $item->adminUpt?->name ?? '-' }}</div>
                            </div> --}}
                            {{-- <div>
                                <div class="text-slate-500">Disposisi / User Layanan</div>

                                <div class="font-medium">{{ $item->adminLayanan->layanan->nama ?? '-' }} /
                                    {{ $item->adminLayanan?->name ?? '-' }}</div>
                            </div> --}}

                            {{-- <div>
                                <div class="text-slate-500">Tanggal Selesai</div>
                                <div class="font-medium">
                                    {{ $item->tanggal_selesai?->format('d M Y H:i') ?? '-' }}
                                </div>
                            </div> --}}
                        </div>

                    </div>
                </section>

                {{-- Bukti Pelapor --}}
                <section>
                    <h2 class="text-base font-semibold text-slate-800 mb-3">Bukti Pelapor</h2>

                    {{-- attachments --}}
                    @if (!empty($item->bukti_masyarakat))
                        <hr class="my-3">
                        <div>
                            <div class="text-xs text-slate-400 mb-2">Attachments</div>
                            <div class="flex flex-wrap gap-3">
                                @foreach ($item->bukti_masyarakat as $file)
                                    @php
                                        // if stored as array of objects or strings
                                        $path =
                                            is_array($file) && isset($file['path'])
                                                ? $file['path']
                                                : (is_string($file)
                                                    ? $file
                                                    : null);
                                        $name =
                                            is_array($file) && isset($file['name'])
                                                ? $file['name']
                                                : basename($path ?? '');
                                    @endphp

                                    @if ($path)
                                        <a href="{{ Storage::url($path) }}" target="_blank"
                                            class="inline-flex items-center gap-2 rounded-lg border p-2 bg-white text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3h-1.5a2 2 0 00-2 2V7">
                                                </path>
                                            </svg>
                                            <span class="text-slate-600">{{ $name }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- @if ($buktiList->isEmpty())
                        <div class="text-sm text-slate-500">Tidak ada bukti terlampir.</div>
                    @else
                        <ul class="list-disc pl-5 space-y-1 text-sm">
                            @foreach ($buktiList as $i => $path)
                                @php
                                    // path bisa link http/https, atau path file di storage
                                    $isUrl = is_string($path) && preg_match('#^https?://#i', $path);
                                    $href = $isUrl ? $path : Storage::disk('public')->url(ltrim($path, '/'));
                                @endphp
                                <li>
                                    <a href="{{ $href }}" target="_blank"
                                        class="text-indigo-600 hover:underline break-all">
                                        Bukti {{ $i + 1 }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif --}}
                </section>

                {{-- Riwayat --}}
                <section>
                    <h2 class="text-base font-semibold text-slate-800 mb-3">Riwayat</h2>
                    <div class="overflow-x-auto rounded-lg border border-slate-200">
                        <table class="min-w-full text-xs">
                            <thead class="bg-slate-100">
                                <tr class="text-slate-700">
                                    <th class="text-left px-3 py-2 border border-slate-200">Waktu</th>
                                    <th class="text-left px-3 py-2 border border-slate-200">User</th>
                                    <th class="text-left px-3 py-2 border border-slate-200">Aksi</th>
                                    <th class="text-left px-3 py-2 border border-slate-200">Status Setelah</th>
                                    <th class="text-left px-3 py-2 border border-slate-200">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($item->logs as $lg)
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-3 py-2 border border-slate-200">
                                            {{ $lg->created_at?->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-3 py-2 border border-slate-200">
                                            {{ $lg->user?->name ?? '-' }}
                                        </td>
                                        <td class="px-3 py-2 border border-slate-200">
                                            {{ $lg->type ?? '-' }}
                                        </td>
                                        <td class="px-3 py-2 border border-slate-200">
                                            {{ str_replace('_', ' ', $lg->status_after ?? '-') }}
                                        </td>
                                        <td class="px-3 py-2 border border-slate-200">
                                            {{ $lg->note ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 py-3 text-center text-slate-500">
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
