{{-- resources/views/pengaduan/show.blade.php --}}

<x-layout :title="$title ?? 'Detail Pengaduan — ' . ($pengaduan->no_tiket ?? '')">
    <div class="max-w-5xl mx-auto px-4 lg:px-0">
        {{-- HEADER --}}
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white mb-6">
            <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h1 class="text-lg font-semibold">Detail Pengaduan</h1>
                        <p class="text-xs text-indigo-100/90">Nomor Tiket: {{ $pengaduan->no_tiket }}</p>
                    </div>

                    <a href="{{ route('pengaduan.index') }}"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm bg-white/20 hover:bg-white/30">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>

            {{-- BODY --}}
            <div class="px-6 py-6 space-y-8">
                {{-- INFO UTAMA --}}
                <div>
                    <h2 class="text-base font-semibold text-slate-700 mb-3">Informasi Utama</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <p class="text-slate-500 text-xs">Judul</p>
                            <p class="font-medium text-slate-800">{{ $pengaduan->judul }}</p>
                        </div>

                        <div class="p-4 border rounded-xl bg-slate-50">
                            <p class="text-slate-500 text-xs">Status</p>
                            <p>
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-full border text-xs {{ $pengaduan->status_badge_class }}">{{ $pengaduan->status_label }}</span>
                            </p>
                        </div>

                        <div class="p-4 border rounded-xl bg-slate-50">
                            <p class="text-slate-500 text-xs">UPT</p>
                            <p class="font-medium">{{ optional($pengaduan->unit)->name ?: '—' }}</p>
                        </div>

                        <div class="p-4 border rounded-xl bg-slate-50">
                            <p class="text-slate-500 text-xs">Admin UPT</p>
                            <p class="font-medium">{{ optional($pengaduan->adminUpt)->name ?: '—' }}</p>
                        </div>
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <p class="text-slate-500 text-xs">Jenis Layanan</p>
                            <p class="font-medium">{{ optional($pengaduan->jenisLayanan)->nama ?: '—' }}</p>
                        </div>

                        <div class="p-4 border rounded-xl bg-slate-50">
                            <p class="text-slate-500 text-xs">Layanan / User Disposisi</p>

                            <div class="flex items-center gap-1">
                                <p class="font-medium">
                                    {{ optional(optional($pengaduan->adminLayanan)->layanan)->nama ?: '—' }} /
                                </p>

                                <p class="text-xs">
                                    {{ optional($pengaduan->adminLayanan)->nip ? 'NIP. ' . $pengaduan->adminLayanan->nip : '—' }}
                                    {{ optional($pengaduan->adminLayanan)->name ?: '—' }}
                                </p>
                            </div>
                        </div>


                        <div class="p-4 border rounded-xl bg-slate-50">
                            <p class="text-slate-500 text-xs">Asal Pengaduan</p>
                            <p class="font-medium">
                                @if ($pengaduan->asal_pengaduan)
                                    {{ $pengaduan->asal_pengaduan ?: '—' }}
                                @else
                                    Sandi Jabar
                                @endif

                            </p>
                        </div>

                        <div class="p-4 border rounded-xl bg-slate-50">
                            <p class="text-slate-500 text-xs">Tanggal Pengaduan</p>
                            <p class="font-medium">{{ optional($pengaduan->created_at)->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                {{-- DATA PELAPOR --}}
                <div>
                    <h2 class="text-base font-semibold text-slate-700 mb-3">Data Pelapor</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="p-4 border rounded-xl bg-slate-50">
                            <p class="text-slate-500 text-xs">Nama Pelapor</p>
                            <p class="font-medium">{{ $pengaduan->pelapor_nama ?: '—' }}</p>
                        </div>

                        <div class="p-4 border rounded-xl bg-slate-50">
                            <p class="text-slate-500 text-xs">Kontak</p>
                            <p class="font-medium">{{ $pengaduan->pelapor_contact ?: '—' }}</p>
                        </div>
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div>
                    <h2 class="text-base font-semibold text-slate-700 mb-3">Deskripsi</h2>
                    <div class="p-4 border rounded-xl bg-slate-50 text-sm leading-relaxed whitespace-pre-line">
                        {{ $pengaduan->deskripsi }}
                    </div>
                </div>

                {{-- BUKTI DARI MASYARAKAT (grid gambar/file) --}}
                <div>
                    <h2 class="text-base font-semibold text-slate-700 mb-3">Bukti dari Masyarakat</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @if ($pengaduan->bukti_masyarakat)
                            @foreach ($pengaduan->bukti_masyarakat as $file)
                                @php
                                    // file bisa berupa string path/URL atau array {path|url, name}
                                    $path = is_array($file) ? $file['path'] ?? ($file['url'] ?? null) : $file;
                                    $name = is_array($file)
                                        ? $file['name'] ?? (is_string($path) ? basename($path) : 'file')
                                        : (is_string($path)
                                            ? basename($path)
                                            : 'file');
                                    $href = $path
                                        ? (\Illuminate\Support\Str::startsWith($path, [
                                            'http://',
                                            'https://',
                                            '/storage/',
                                        ])
                                            ? $path
                                            : Storage::url($path))
                                        : null;
                                @endphp
                                @if ($href)
                                    <a href="{{ $href }}" target="_blank" class="block group">
                                        <div
                                            class="aspect-square rounded-xl overflow-hidden border bg-slate-100 flex items-center justify-center">
                                            <img src="{{ $href }}"
                                                class="w-full h-full object-cover group-hover:opacity-80"
                                                onerror="this.style.display='none'">
                                        </div>
                                        {{--  {{ $name }} --}}
                                        <p class="text-xs mt-1 truncate">Bukti Pendukung</p>
                                    </a>
                                @else
                                    <div class="p-4 border rounded-xl bg-slate-50 text-xs text-slate-500">File tidak
                                        valid</div>
                                @endif
                            @endforeach
                        @else
                            <p class="text-sm text-slate-500">Tidak ada bukti.</p>
                        @endif
                    </div>
                </div>

                <div>
                    <h2 class="text-base font-semibold text-slate-700 mb-3">Petugas Yang Menindak Lanjuti</h2>
                    <div class="p-4 border rounded-xl bg-slate-50 text-sm leading-relaxed whitespace-pre-line">
                        {{ $pengaduan->petugas_nama }}
                    </div>
                </div>

                <div>
                    <h2 class="text-base font-semibold text-slate-700 mb-3">Penyelesaian</h2>
                    <div class="p-4 border rounded-xl bg-slate-50 mb-3">
                        <p class="text-slate-500 text-xs">Petugas Yang Menindak Lanjuti</p>
                        <p class="font-medium">{{ $pengaduan->petugas_nama ?: '—' }}</p>
                    </div>
                    <div class="p-4 border rounded-xl bg-slate-50">
                        <p class="text-slate-500 text-xs">Hasil Tindak Lanjut</p>
                        <p class="font-medium">{{ $pengaduan->hasil_tindaklanjut ?: '—' }}</p>
                    </div>

                </div>

                {{-- DOKUMEN PENYELESAIAN (table + unduh) --}}
                @php
                    $docs = $pengaduan->dokumen_penyelesaian;
                    if (is_string($docs) && trim($docs) !== '') {
                        $docs = [$docs];
                    }
                    if (!is_array($docs)) {
                        $docs = [];
                    }
                @endphp
                <div>
                    <h2 class="text-base font-semibold text-slate-700 mb-3">Dokumen Penyelesaian</h2>
                    <div class="overflow-x-auto rounded-xl border">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600 border-b">
                                <tr>
                                    <th class="text-left py-3 px-3 w-14">No</th>
                                    <th class="text-left py-3 px-3">Nama Dokumen</th>
                                    <th class="text-left py-3 px-3">Tautan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($docs as $i => $file)
                                    @php
                                        // Ambil path dari DB
                                        $path = is_array($file) ? $file['path'] ?? null : $file;

                                        // Nama file
                                        $name = is_array($file) ? $file['name'] ?? basename($path) : basename($path);

                                        // Jika path sudah URL penuh (http/https), pakai apa adanya
                                        if ($path && Str::startsWith($path, ['http://', 'https://'])) {
                                            $href = $path;
                                        }
                                        // Jika path lokal → bentuk manual
                                        elseif ($path) {
                                            // pastikan path tidak diawali slash
                                            $cleanPath = ltrim($path, '/');
                                            $href = rtrim(env('APP_URL'), '/') . '/storage/' . $cleanPath;
                                        } else {
                                            $href = null;
                                        }
                                    @endphp

                                    <tr class="border-b last:border-0">
                                        <td class="py-3 px-3">{{ $i + 1 }}</td>
                                        <td class="py-3 px-3">Dokumen Pendukung</td>
                                        <td class="py-3 px-3">
                                            @if ($href)
                                                <a href="{{ $href }}" target="_blank"
                                                    class="underline">Lihat</a>
                                                <a href="{{ $href }}" download class="underline ml-3">Unduh</a>
                                            @else
                                                <span class="text-slate-500">Tidak tersedia</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-6 text-center text-slate-500">Tidak ada dokumen
                                            penyelesaian.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- RIWAYAT (table tampilan seperti contoh) --}}
                <div>
                    <h2 class="text-base font-semibold text-slate-700 mb-3">Riwayat</h2>
                    <div class="overflow-x-auto rounded-xl border">
                        <table class="min-w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600 border-b">
                                <tr>
                                    <th class="text-left py-3 px-3">Waktu</th>
                                    <th class="text-left py-3 px-3">User</th>
                                    <th class="text-left py-3 px-3">Aksi</th>
                                    <th class="text-left py-3 px-3">Status</th>
                                    <th class="text-left py-3 px-3">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengaduan->logs as $log)
                                    <tr class="border-b last:border-0">
                                        <td class="py-3 px-3 whitespace-nowrap">
                                            {{ optional($log->created_at)->format('d M Y H:i') }}</td>
                                        <td class="py-3 px-3">{{ optional($log->user)->name ?: '—' }}</td>
                                        <td class="py-3 px-3">
                                            {{ $log->aksi ?? ($log->action ?? ($log->tipe ?? ($log->type ?? '—'))) }}
                                        </td>
                                        <td class="py-3 px-3">
                                            {{ $log->status_setelah ?? ($log->status_after ?? '—') }}
                                        </td>
                                        <td class="py-3 px-3 whitespace-normal wrap-break-words max-w-md">
                                            {{ $log->catatan ?? ($log->note ?? '—') }}
                                        </td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-slate-500">Belum ada riwayat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @include('components.alert')
    </div>
</x-layout>
