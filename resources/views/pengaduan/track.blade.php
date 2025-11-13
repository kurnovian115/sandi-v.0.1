<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sandi Jabar - Pengaduan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
</head>

<body class="relative min-h-screen bg-gray-900 overflow-x-hidden">

    <!-- Background logo transparan + overlay gradasi putih lembut -->
    <div class="absolute inset-0 bg-linear-to-b from-white/90 via-white/95 to-white pointer-events-none"></div>

    <!-- Header sederhana dengan tombol Lacak Tiket -->
    <nav class="fixed top-0 z-50 w-full bg-blue-800 border-b border-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-3">
                        <img src="/images/logo.png" alt="Logo SANDI JABAR" class="w-8 h-8 object-contain" />
                        <span class="text-white text-lg font-semibold">SANDI JABAR</span>
                    </a>
                </div>
                <!-- Tombol Lacak Tiket -->
                <a href="{{ route('pengaduan.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-sky-500  text-white text-sm font-medium shadow-sm hover:from-indigo-700 hover:to-sky-600 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                    </svg>
                    Tambah Pengaduan
                </a>


            </div>
        </div>
    </nav>

    <div class="fixed left-2 bottom-0 pb-4 z-50">
        <a href="{{ url('/') }}" role="button"
            class="inline-flex items-center gap-3 px-4 py-2.5 rounded-full shadow-xl
               bg-gradient-to-r from-indigo-600 to-sky-500 text-white
               hover:brightness-110 hover:scale-105 transition-transform">
            <!-- Ikon selalu muncul -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16"
                aria-hidden="true">
                <path d="M8 .5l6 5V15a1 1 0 0 1-1 1h-3v-4H6v4H3a1 1 0 0 1-1-1V5.5l6-5z" />
            </svg>
            <!-- Teks hanya tampil di sm ke atas -->
            <span class="hidden sm:inline font-medium">
                Kembali ke Beranda
            </span>
        </a>
    </div>

    <!-- Konten utama -->
    <main class="relative z-10 pt-24 pb-12">
        <div class="max-w-3xl mx-auto px-4 py-8">
            <div class="rounded-2xl overflow-hidden shadow border bg-white">
                <header class="px-6 py-4 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                    <h1 class="text-lg font-semibold">Lacak Tiket</h1>
                    <p class="text-sm text-indigo-100/90 mt-1">Masukkan nomor tiket untuk melihat status pengaduan Anda.
                    </p>
                </header>

                <div class="px-6 py-6">
                    {{-- Search form (GET so url bisa dibagikan) {{ route('pengaduan.track') }} --}}
                    <form method="GET" action="#" class="flex gap-3 items-center">
                        <input type="text" name="q" value="{{ old('q', $q ?? '') }}"
                            placeholder="Masukkan nomor tiket (contoh: IMI-JBR-2025...)" required
                            class="flex-1 rounded-lg border px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300">

                        <button type="submit"
                            class="px-4 py-2 rounded-lg bg-sky-600 hover:bg-sky-700 text-white text-sm">Cari</button>
                    </form>

                    {{-- result area --}}
                    <div class="mt-6">
                        @if (isset($pengaduan) && $pengaduan)
                            <div class="rounded-lg border p-4 bg-white">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="text-xs text-slate-500">Ticket No.</div>
                                        <div class="text-sm font-semibold">{{ $pengaduan->no_tiket }}</div>
                                    </div>

                                    <div class="text-right">
                                        <div class="text-xs text-slate-400">Status</div>
                                        <div>
                                            @php $st = $pengaduan->status ?? 'unknown'; @endphp
                                            @if ($st === 'Menunggu')
                                                <span
                                                    class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs">Menunggu
                                                    / Waiting</span>
                                            @elseif($st === 'Diproses' || $st === 'Proses' || $st === 'Disposisi_ke_layanan')
                                                <span
                                                    class="px-2 py-1 rounded bg-blue-100 text-blue-800 text-xs">Diproses
                                                    / Processed</span>
                                            @elseif($st === 'Selesai')
                                                <span
                                                    class="px-2 py-1 rounded bg-emerald-100 text-emerald-800 text-xs">Selesai
                                                    / Finish</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 rounded bg-slate-100 text-slate-800 text-xs">{{ ucfirst($st) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-3">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <div class="text-xs text-slate-400">Imigration Office</div>
                                        <div class="font-medium">
                                            {{ $pengaduan->unit->name ?? ($pengaduan->unit_id ?? '-') }}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-xs text-slate-400">Category / Service</div>
                                        <div class="font-medium">
                                            {{ $pengaduan->kategoriPengaduan->nama ?? ($pengaduan->kategori_id ?? '-') }}
                                            @if ($pengaduan->jenisLayanan)
                                                <span class="text-slate-400"> /
                                                    {{ $pengaduan->jenisLayanan->nama ?? $pengaduan->jenis_layanan_id }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="md:col-span-2">
                                        <div class="text-xs text-slate-400">Title</div>
                                        <div class="font-medium">{{ $pengaduan->judul ?? '-' }}</div>
                                    </div>

                                    <div class="md:col-span-2">
                                        <div class="text-xs text-slate-400">Description</div>
                                        <div class="text-sm text-slate-700 mt-1 whitespace-pre-line">
                                            {{ $pengaduan->deskripsi ?? '-' }}</div>
                                    </div>
                                </div>

                                {{-- attachments --}}
                                @if (!empty($pengaduan->bukti_masyarakat))
                                    <hr class="my-3">
                                    <div>
                                        <div class="text-xs text-slate-400 mb-2">Attachments</div>
                                        <div class="flex flex-wrap gap-3">
                                            @foreach ($pengaduan->bukti_masyarakat as $file)
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
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 text-slate-500" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
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

                                <div class="mt-4 text-xs text-slate-500">
                                    Submitted: {{ optional($pengaduan->created_at)->format('d M Y H:i') ?? '-' }}
                                </div>
                            </div>
                        @elseif(isset($q) && $q !== '')
                            <div class="rounded-lg border p-4 bg-rose-50 text-rose-800">
                                Tidak ditemukan tiket dengan nomor <strong>{{ $q }}</strong>.
                            </div>
                        @else
                            <div class="text-sm text-slate-500">Masukkan nomor tiket di atas lalu klik *Cari*.</div>
                        @endif

                        <hr class="mt-6 mb-4 border-t border-slate-200">
                        {{-- TIMELINE --}}
                        @if ($pengaduan)
                            <div class="mt-6">
                                <h3 class="text-sm font-semibold text-slate-700 mb-2">Timeline</h3>
                                <div class="space-y-3">
                                    @forelse($pengaduan->logs as $log)
                                        <div class="flex gap-3 items-start">
                                            <div class="w-28 text-xs text-slate-500">
                                                {{ $log->created_at->format('d M Y H:i') }}</div>
                                            <div class="flex-1 rounded-lg border p-3 bg-white">
                                                <div class="flex items-center justify-between">
                                                    <div class="text-sm">
                                                        <span class="font-medium">
                                                            @if ($log->type === 'create')
                                                                Pengaduan dibuat / Create Complaint
                                                            @elseif($log->type === 'tarik_kembali')
                                                                Diproses / Processed
                                                            @elseif($log->type === 'disposisi')
                                                                Diproses / Processed
                                                            @elseif($log->type === 'jawab')
                                                                Selesai / Finish
                                                            @else
                                                                {{ ucfirst($log->type) }}
                                                            @endif
                                                        </span>
                                                        <span class="text-slate-400 text-xs">
                                                            @if ($log->type === 'disposisi')
                                                                oleh User Layanan / By Service User
                                                            @elseif ($log->type === 'tarik_kembali')
                                                                Oleh Admin / By Admin
                                                            @elseif ($log->user)
                                                                oleh {{ $log->user->name }}
                                                            @else
                                                                oleh Masyarakat (publik)
                                                            @endif
                                                        </span>
                                                    </div>

                                                    @if ($log->type === 'status')
                                                        <div>
                                                            @if ($log->status_after === 'selesai')
                                                                <span
                                                                    class="px-2 py-1 rounded bg-emerald-100 text-emerald-800 text-xs">Selesai</span>
                                                            @elseif(in_array($log->status_after, ['diproses', 'proses']))
                                                                <span
                                                                    class="px-2 py-1 rounded bg-blue-100 text-blue-800 text-xs">Diproses</span>
                                                            @else
                                                                <span
                                                                    class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs">{{ $log->status_after }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>

                                                @if ($log->note)
                                                    <div class="text-sm text-slate-700 mt-2">{{ $log->note }}</div>
                                                @endif

                                                {{-- file di log --}}
                                                @if (!empty($log->meta['file']))
                                                    <div class="mt-3">
                                                        <a href="{{ Storage::url($log->meta['file']) }}"
                                                            target="_blank"
                                                            class="inline-flex items-center gap-2 rounded-lg border px-3 py-2 text-sm bg-white">
                                                            <svg class="h-4 w-4 text-slate-500" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor">
                                                                <path d="M..." />
                                                            </svg>
                                                            {{ $log->meta['name'] ?? basename($log->meta['file']) }}
                                                        </a>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-sm text-slate-500">Belum ada aktivitas.</div>
                                    @endforelse
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
