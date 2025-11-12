{{-- FILE: resources/views/upt/pengaduan/index.blade.php --}}
<x-layout :title="$title ?? 'Pengaduan UPT'">
    <div class="max-w-6xl mx-auto px-4 lg:px-0" x-data="uptPengaduan()">

        {{-- HEADER --}}
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h1 class="text-lg font-semibold">Monitoring & Verifikasi Pengaduan</h1>
                        <p class="text-xs text-indigo-100/90">
                            Admin UPT memverifikasi & mendisposisi pengaduan yang masuk pada UPT-nya.
                        </p>
                    </div>
                </div>
            </div>

            {{-- FILTER BAR --}}
            <div class="px-6 py-4 border-b border-slate-200 bg-white">
                <form method="GET"
                    class="max-w-5xl mx-auto flex flex-col gap-2 lg:flex-row lg:flex-wrap lg:items-center lg:justify-center lg:gap-2">

                    {{-- Search --}}
                    <div class="w-full lg:w-auto lg:flex lg:items-stretch gap-0">
                        <input type="text" name="q" value="{{ $q ?? '' }}"
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
                            <option value="menunggu" @selected(($status ?? '') === 'menunggu')>Menunggu</option>
                            <option value="proses" @selected(($status ?? '') === 'proses')>Proses</option>
                            <option value="selesai" @selected(($status ?? '') === 'selesai')>Selesai</option>
                            <option value="ditolak" @selected(($status ?? '') === 'ditolak')>Ditolak</option>
                        </select>
                        <i
                            class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>

                    {{-- Range tanggal masuk --}}
                    <div class="w-full lg:w-auto flex items-stretch gap-2">
                        <input type="date" name="start" value="{{ $start ?? '' }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <span class="self-center text-slate-400">—</span>
                        <input type="date" name="end" value="{{ $end ?? '' }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Reset --}}
                    <a href="{{ route('upt.pengaduan.index') }}"
                        class="w-full lg:w-auto inline-flex items-center justify-center gap-1 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-800 px-3 py-2 text-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="px-6 py-4 bg-white">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs border border-slate-300">
                        <thead class="text-left text-slate-500">
                            <tr>
                                <th class="border border-slate-200 px-2 py-3">UPT</th>
                                <th class="border border-slate-200 px-2 py-3">No. Tiket</th>
                                <th class="border border-slate-200 px-2 py-3">Judul</th>
                                <th class="border border-slate-200 px-2 py-3">Status</th>
                                <th class="border border-slate-200 px-2 py-3">Tgl Masuk</th>
                                <th class="border border-slate-200 px-2 py-3">Disposisi ke</th>
                                <th class="border border-slate-200 px-2 py-3">Tgl Selesai</th>
                                <th class="border border-slate-200 px-2 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse($list as $row)
                                @php($s = strtolower($row->status ?? 'menunggu'))
                                <tr>
                                    {{-- UPT (pakai unit_nama dari SELECT, bukan relasi) --}}
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        {{ $row->unit_nama ?? '-' }}
                                    </td>

                                    {{-- Nomor tiket --}}
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        {{ $row->kode ?? 'PGD-' . $row->id }}
                                    </td>

                                    {{-- Judul --}}
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle max-w-[40ch] truncate"
                                        title="{{ $row->judul }}">
                                        {{ $row->judul }}
                                    </td>

                                    {{-- Status badge --}}
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        <span
                                            class="px-2 py-1 rounded-full text-[10px]
                                        {{ $s === 'selesai'
                                            ? 'bg-green-100 text-green-700'
                                            : ($s === 'ditolak'
                                                ? 'bg-red-100 text-red-700'
                                                : ($s === 'proses'
                                                    ? 'bg-yellow-100 text-yellow-700'
                                                    : 'bg-slate-100 text-slate-700')) }}">
                                            {{ ucfirst($row->status ?? '-') }}
                                        </span>
                                    </td>

                                    {{-- Tgl masuk (created_at) --}}
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        {{ !empty($row->created_at) ? date('d M Y H:i', strtotime($row->created_at)) : '-' }}
                                    </td>

                                    {{-- Disposisi ke (jenis layanan — admin) --}}
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        {{ ($row->layanan_nama ?? null) && ($row->admin_nama ?? null)
                                            ? $row->layanan_nama . ' — ' . $row->admin_nama
                                            : '-' }}
                                    </td>

                                    {{-- Tgl selesai (tanggal_selesai) --}}
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        {{ !empty($row->tanggal_selesai) ? date('d M Y H:i', strtotime($row->tanggal_selesai)) : '-' }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="border border-slate-200 px-2 py-3 text-xs align-middle">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ url('/pengaduan/' . $row->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                                                Detail
                                            </a>
                                            <button type="button" @click="openDisposisi({ id: {{ $row->id }} })"
                                                class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                                                Verifikasi & Disposisi
                                            </button>
                                            <button type="button" @click="openTolak({ id: {{ $row->id }} })"
                                                class="inline-flex items-center px-3 py-1.5 rounded-lg bg-rose-600 text-white hover:bg-rose-700">
                                                Tolak
                                            </button>
                                        </div>
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

                <div class="mt-4">
                    {{ $list->links() }}
                </div>
            </div>
        </div>

        {{-- MODAL: Disposisi --}}
        <div x-show="modals.disposisi" x-cloak class="fixed inset-0 z-50 grid place-items-center bg-black/40 p-4">
            <div class="w-full max-w-lg rounded-2xl bg-white shadow p-5">
                <h3 class="text-base font-semibold mb-3">Verifikasi & Disposisi</h3>
                <form method="POST" :action="routes.disposisi(modals.payload.id)">
                    @csrf
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Jenis Layanan</label>
                            <select x-model="form.layanan_id" name="jenis_layanan_id" @change="form.admin_id='';"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                <option value="">Pilih layanan...</option>
                                @foreach ($layanans as $l)
                                    <option value="{{ $l->id }}">{{ $l->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Petugas (Admin Layanan)</label>
                            <select name="admin_layanan_id" x-model="form.admin_id" :disabled="!form.layanan_id"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                <option value="" x-show="!form.layanan_id">Pilih layanan dulu</option>
                                <template x-for="p in filteredPetugas()" :key="p.id">
                                    <option :value="p.id" x-text="p.name"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Catatan (opsional)</label>
                            <textarea name="catatan" rows="3"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Tambahkan catatan untuk petugas (opsional)"></textarea>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end gap-2">
                        <button type="button" @click="closeDisposisi()"
                            class="px-3 py-1.5 rounded-lg border border-slate-300">Batal</button>
                        <button
                            class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL: Tolak --}}
        <div x-show="modals.tolak" x-cloak class="fixed inset-0 z-50 grid place-items-center bg-black/40 p-4">
            <div class="w-full max-w-lg rounded-2xl bg-white shadow p-5">
                <h3 class="text-base font-semibold mb-3">Tolak Pengaduan</h3>
                <form method="POST" :action="routes.tolak(modals.payload.id)">
                    @csrf
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Alasan</label>
                        <textarea name="alasan" rows="4"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Tuliskan alasan penolakan" required></textarea>
                    </div>
                    <div class="mt-4 flex justify-end gap-2">
                        <button type="button" @click="closeTolak()"
                            class="px-3 py-1.5 rounded-lg border border-slate-300">Batal</button>
                        <button class="px-3 py-1.5 rounded-lg bg-rose-600 text-white hover:bg-rose-700">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Alpine helper --}}
    <script>
        function uptPengaduan() {
            return {
                modals: {
                    disposisi: false,
                    tolak: false,
                    payload: {}
                },
                form: {
                    layanan_id: '',
                    admin_id: ''
                },
                petugas: @json($petugas ?? []), // harus berisi: [{id, name, jenis_layanan_id}, ...]
                routes: {
                    disposisi: (id) => `{{ route('upt.pengaduan.disposisi', ':id') }}`.replace(':id', id),
                    tolak: (id) => `{{ route('upt.pengaduan.tolak', ':id') }}`.replace(':id', id),
                },
                openDisposisi(payload) {
                    this.modals.payload = payload;
                    this.modals.disposisi = true;
                },
                closeDisposisi() {
                    this.modals.payload = {};
                    this.modals.disposisi = false;
                    this.form = {
                        layanan_id: '',
                        admin_id: ''
                    };
                },
                openTolak(payload) {
                    this.modals.payload = payload;
                    this.modals.tolak = true;
                },
                closeTolak() {
                    this.modals.payload = {};
                    this.modals.tolak = false;
                },
                filteredPetugas() {
                    if (!this.form.layanan_id) return [];
                    return this.petugas.filter(p => String(p.jenis_layanan_id) === String(this.form.layanan_id));
                }
            }
        }
    </script>
</x-layout>
