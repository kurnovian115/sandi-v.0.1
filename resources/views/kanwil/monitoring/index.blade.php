<x-layout :title="$title ?? 'Monitoring Semua Pengaduan'">
    <div class="max-w-6xl mx-auto px-4 lg:px-0">

        {{-- HEADER --}}
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h1 class="text-lg font-semibold">Monitoring Semua Pengaduan</h1>
                        <p class="text-xs text-indigo-100/90">Pantau seluruh pengaduan yang masuk dan status
                            penanganannya.</p>
                    </div>
                </div>
            </div>

            {{-- FILTER BAR --}}
            <div class="px-6 py-4 border-b border-slate-200 bg-white">
                <form method="GET"
                    class="max-w-5xl mx-auto flex flex-col gap-2 lg:flex-row lg:flex-wrap lg:items-center lg:justify-center lg:gap-2">
                    {{-- Search --}}
                    <div class="w-full lg:w-auto lg:flex lg:items-stretch gap-0">
                        <input type="text" name="q" value="{{ $q }}"
                            placeholder="Cari judul / no tiket"
                            class="w-full rounded-lg lg:rounded-l-lg lg:rounded-r-none border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit"
                            class="cursor-pointer mt-2 w-full lg:mt-0 lg:w-auto flex items-center justify-center gap-2 rounded-lg lg:rounded-r-lg lg:rounded-l-none bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 text-sm font-medium transition">
                            <i class="bi bi-search"></i>
                            <span>Cari</span>
                        </button>
                    </div>

                    {{-- Status --}}
                    <div class="relative w-full lg:w-48">
                        <select name="status"
                            class="w-full appearance-none rounded-lg border border-slate-300 px-3 pr-9 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Status</option>
                            <option value="proses" @selected(($status ?? '') === 'proses')>Proses</option>
                            <option value="selesai" @selected(($status ?? '') === 'selesai')>Selesai</option>
                            <option value="ditolak" @selected(($status ?? '') === 'ditolak')>Ditolak</option>
                        </select>
                        <i
                            class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>

                    {{-- Unit/UPT --}}
                    <div class="relative w-full lg:w-64">
                        <select name="unit_id"
                            class="w-full appearance-none rounded-lg border border-slate-300 px-3 pr-9 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua UPT</option>
                            @foreach ($upts as $u)
                                <option value="{{ $u->id }}" @selected(($unitId ?? null) == $u->id)>{{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                        <i
                            class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>

                    {{-- Range tanggal masuk --}}
                    <div class="w-full lg:w-auto flex items-stretch gap-2">
                        <input type="date" name="start" value="{{ $start }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <span class="self-center text-slate-400">—</span>
                        <input type="date" name="end" value="{{ $end }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Terapkan & Reset --}}
                    <button type="submit"
                        class="cursor-pointer w-full lg:w-auto inline-flex items-center justify-center gap-1 rounded-lg bg-sky-600 hover:bg-sky-700 text-white px-3 py-2 text-sm">
                        <i class="bi bi-funnel"></i> Terapkan
                    </button>
                    <a href="{{ route('kanwil.monitoring.index') }}"
                        class="w-full lg:w-auto inline-flex items-center justify-center gap-1 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-800 px-3 py-2 text-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="px-6 py-4 bg-white">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left bg-slate-100">
                            <tr class = " text-slate-700">
                                <th class="border border-slate-200 px-2 py-1 text-xs align-middle">UPT</th>
                                <th class="border border-slate-200 px-2 py-1 text-xs align-middle">No. Tiket</th>
                                <th class="border border-slate-200 px-2 py-1 text-xs align-middle">Judul</th>
                                <th class="border border-slate-200 px-2 py-1 text-xs align-middle">Status</th>
                                <th class="border border-slate-200 px-2 py-1 text-xs align-middle">Tgl Masuk</th>
                                <th class=\"border border-slate-200 px-2 py-1 text-xs align-middle\">Disposisi ke</th>
                                <th class="border border-slate-200 px-2 py-1 text-xs align-middle">Tgl Selesai</th>
                                <th class="py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($list as $row)
                                @php($s = strtolower($row->status ?? 'proses'))
                                <tr>
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        {{ optional($row->unit)->name ?? '-' }}</td>
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        {{ $row->kode ?? 'IMI-' . $row->id }}</td>
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle max-w-[40ch] truncate"
                                        title="{{ $row->judul }}">
                                        {{ $row->judul }}</td>
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs {{ $s === 'selesai' ? 'bg-green-100 text-green-700' : ($s === 'ditolak' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ ucfirst($row->status) }}</span>
                                    </td>
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        {{ $row->masuk_at ? date('d M Y H:i', strtotime($row->masuk_at)) : '-' }}
                                    </td>
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        {{ $row->layanan_nama && $row->admin_nama ? $row->layanan_nama . ' — ' . $row->admin_nama : '-' }}
                                    </td>
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        {{ $row->selesai_at ? date('d M Y H:i', strtotime($row->selesai_at)) : '-' }}
                                        {{-- {{ optional($row->selesai_at)->format('d M Y') ?: '-' }}</td> --}}
                                    <td class="py-2">
                                        @php($detailUrl = Route::has('kanwil.pengaduan.show') ? route('kanwil.pengaduan.show', $row->id) : (Route::has('kanwil.monitoring.show') ? route('kanwil.monitoring.show', $row->id) : url('/pengaduan/' . $row->id)))
                                        <a href="{{ $detailUrl }}"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-6 text-center text-slate-400">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $list->links() }}</div>
            </div>
        </div>
    </div>
</x-layout>
