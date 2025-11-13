{{-- resources/views/upt/disposisi/index.blade.php --}}
@php use App\Models\Pengaduan; @endphp

<x-layout :title="$title ?? 'Pengaduan Masuk'">
    <div class="max-w-6xl mx-auto px-4 lg:px-0">

        {{-- HEADER --}}
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h1 class="text-lg font-semibold">Pengaduan Masuk</h1>
                        <p class="text-xs text-indigo-100/90">Daftar Pengaduan yang Belum ditindak lanjuti.</p>
                    </div>
                </div>
            </div>

            {{-- FILTER BAR (tidak diubah) --}}
            <div class="px-6 py-4 border-b border-slate-200 bg-white">
                <form method="GET"
                    class="max-w-4xl mx-auto flex flex-col gap-2 lg:flex-row lg:flex-wrap lg:items-center lg:justify-center lg:gap-2">
                    <div class="w-full lg:w-auto lg:flex lg:items-stretch gap-0">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari no tiket / nama / judul"
                            class="w-full rounded-lg lg:rounded-l-lg lg:rounded-r-none border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit"
                            class="cursor-pointer mt-2 w-full lg:mt-0 lg:w-auto flex items-center justify-center gap-2 rounded-lg lg:rounded-r-lg lg:rounded-l-none bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 text-sm font-medium transition">
                            <i class="bi bi-search"></i>
                            <span>Cari</span>
                        </button>
                    </div>
                    <a href="{{ route('upt.disposisi.index') }}"
                        class="w-full lg:w-auto inline-flex items-center justify-center gap-1 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-800 px-3 py-2 text-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </form>

                @if (session('success'))
                    <div class="mt-3 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-2 text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('warning'))
                    <div class="mt-3 rounded-lg bg-amber-50 border border-amber-200 px-4 py-2 text-amber-700">
                        {{ session('warning') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mt-3 rounded-lg bg-rose-50 border border-rose-200 px-4 py-2 text-rose-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- TABLE --}}
            <div class="px-6 py-4">
                <div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm">
                    <table class="min-w-full border-collapse text-sm">
                        <thead class="bg-slate-100">
                            <tr class="text-slate-700 font-semibold">
                                <th class="border border-slate-200 px-4 py-3 text-left">No Tiket</th>
                                <th class="border border-slate-200 px-4 py-3 text-left">Pelapor</th>
                                <th class="border border-slate-200 px-4 py-3 text-left">Judul</th>
                                <th class="border border-slate-200 px-4 py-3 text-left">Status</th>
                                {{-- <th class="border border-slate-200 px-4 py-3 text-left">Disposis - User Layanan</th> --}}
                                <th class="border border-slate-200 px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $row)
                                {{-- FIX: tambahkan openDetail di x-data --}}
                                <tr class="hover:bg-slate-50 transition" x-data="{ openDispo: false, openJawab: false, openDetail: false }">
                                    <td class="border border-slate-200 px-4 py-3 font-medium">{{ $row->no_tiket }}</td>
                                    <td class="border border-slate-200 px-4 py-3">{{ $row->pelapor_nama }}</td>
                                    <td class="border border-slate-200 px-4 py-3">{{ $row->judul }}</td>

                                    <td class="border border-slate-200 px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 text-xs font-medium rounded-full border bg-amber-50 text-amber-700 border-amber-200">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current/60"></span>
                                            {{-- @dd($row->status_label) --}}
                                            @if ($row->status_label === 'Diproses oleh user layanan ')
                                                Menunggu
                                            @else
                                                {{ $row->status_label }}
                                            @endif
                                        </span>
                                    </td>

                                    {{-- <td class="border border-slate-200 px-4 py-3">
                                        {{ $row->adminLayanan?->layanan?->nama }} -
                                        {{ $row->adminLayanan?->name }}
                                    </td> --}}

                                    <td class="border border-slate-200 px-4 py-3 text-left whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">

                                            <a href="{{ route('layanan.pengaduan.inbox.show', $row) }}"
                                                class="cursor-pointer  inline-flex items-center gap-1.5 px-3 py-1 text-xs rounded-md border border-indigo-300 text-indigo-700 hover:bg-indigo-50 transition font-medium">
                                                Detail
                                            </a>

                                            {{-- Tarik Kembali hanya saat disposisi --}}
                                            {{-- @if ($row->status === Pengaduan::STATUS_DISPOSISI)
                                                <form method="post" action="{{ route('upt.disposisi.recall', $row) }}"
                                                    onsubmit="return confirm('Tarik kembali pengaduan ini?')">
                                                    @csrf
                                                    <button
                                                        class="cursor-pointer  inline-flex items-center gap-1.5 px-3 py-1 text-xs rounded-md border border-rose-300 text-rose-700 hover:bg-rose-50">
                                                        Tarik Kembali
                                                    </button>
                                                </form> --}}
                                            {{-- @else --}}
                                            {{-- Disposisi --}}
                                            {{-- <button @click="openDispo = true"
                                                    class="cursor-pointer  inline-flex items-center gap-1.5 px-3 py-1 text-xs rounded-md border border-yellow-300 text-yellow-700 hover:bg-yellow-50 transition font-medium">
                                                    Disposisi
                                                </button> --}}
                                            {{-- Jawab --}}
                                            <button @click="openJawab = true"
                                                class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1 text-xs rounded-md border border-green-100 bg-green-600 text-white hover:bg-green-700">
                                                Jawab
                                            </button>
                                            {{-- @endif --}}
                                        </div>

                                        {{-- MODAL JAWAB (tidak diubah)… --}}
                                        <div class="fixed inset-0 z-[60] bg-black/40 backdrop-blur-sm"
                                            x-show="openJawab" x-transition.opacity
                                            @keydown.escape.window="openJawab=false" style="display:none">
                                            <div class="min-h-full flex items-center justify-center p-4">
                                                <div class="w-full max-w-xl rounded-2xl bg-white shadow-xl border border-slate-200"
                                                    x-show="openJawab" x-transition.scale>
                                                    <div class="px-5 py-4 rounded-t-2xl bg-slate-50 border-b">
                                                        <h3 class="font-semibold">Jawab Pengaduan:
                                                            {{ $row->no_tiket }}</h3>
                                                    </div>
                                                    <form method="post" enctype="multipart/form-data"
                                                        action="{{ route('layanan.pengaduan.inbox.jawab', $row) }}"
                                                        class="p-5 space-y-4">
                                                        @csrf
                                                        <label class="block text-sm">
                                                            <span class="mb-1 block text-slate-700">Nama Petugas</span>
                                                            <input name="petugas_nama" required
                                                                class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                                                        </label>
                                                        <label class="block text-sm">
                                                            <span class="mb-1 block text-slate-700">Hasil Tindak
                                                                Lanjut</span>
                                                            <textarea name="hasil_tindaklanjut" rows="5" required
                                                                class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                                        </label>
                                                        <label class="block text-sm">
                                                            <span class="mb-1 block text-slate-700">Dokumen (opsional,
                                                                pdf/jpg/png, max 4MB)</span>
                                                            <input type="file" name="dokumen_penyelesaian"
                                                                class="w-full rounded-lg border border-slate-300 px-3 py-2 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:bg-slate-100 file:text-slate-700">
                                                        </label>
                                                        <div class="flex items-center justify-end gap-2 pt-2">
                                                            <button type="button" @click="openJawab=false"
                                                                class="px-3 py-2 rounded-lg border border-slate-300 hover:bg-slate-50">Batal</button>
                                                            <button
                                                                class="px-3 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white">Kirim
                                                                Jawaban</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="border border-slate-200 px-4 py-6 text-center text-slate-500 text-sm">
                                        Belum ada pengaduan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>
