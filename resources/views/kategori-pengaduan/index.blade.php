<x-layout :title="$title ?? 'Kategori Pengaduan'">
    <div class="max-w-6xl mx-auto px-4 lg:px-0" x-data>
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            <div
                class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold">Kategori Pengaduan</h1>
                    <p class="text-xs text-indigo-100/90">Kelola kategori pengaduan yang akan dipilih saat verifikasi.
                    </p>
                </div>
                {{-- <a href="{{ route('kategori-pengaduan.tambah') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm bg-emerald-600 hover:bg-emerald-700 shadow-sm text-white">
                    <i class="bi bi-plus-lg"></i> Tambah Kategori
                </a> --}}
            </div>

            <div class="px-6 py-4 border-b border-slate-200 bg-white">
                {{-- <form method="GET"
                    class="max-w-4xl mx-auto flex flex-col gap-2 lg:flex-row lg:flex-wrap lg:items-center lg:justify-center lg:gap-2">
                    <div class="w-full lg:w-auto lg:flex lg:items-stretch gap-0">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari nama / kode kategori"
                            class="w-full rounded-lg lg:rounded-l-lg lg:rounded-r-none border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit"
                            class="cursor-pointer mt-2 w-full lg:mt-0 lg:w-auto flex items-center justify-center gap-2 rounded-lg lg:rounded-r-lg lg:rounded-l-none bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 text-sm font-medium transition">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>

                    <div class="relative w-full lg:w-48">
                        <select name="status"
                            class="w-full appearance-none rounded-lg border border-slate-300 px-3 pr-9 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Status</option>
                            <option value="1" @selected(request('is_active') === '1')>Aktif</option>
                            <option value="0" @selected(request('is_active') === '0')>Nonaktif</option>
                        </select>
                        <i
                            class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>

                    <button type="submit"
                        class="cursor-pointer w-full lg:w-auto inline-flex items-center justify-center gap-1 rounded-lg bg-sky-600 hover:bg-sky-700 text-white px-3 py-2 text-sm">
                        <i class="bi bi-funnel"></i> Terapkan
                    </button>

                    <a href="{{ route('kategori-pengaduan.index') }}"
                        class="w-full lg:w-auto inline-flex items-center justify-center gap-1 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-800 px-3 py-2 text-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </form> --}}

                <div class="mt-4 max-w-4xl mx-auto">
                    <div class="overflow-x-auto bg-white">
                        <table class="w-full text-sm border">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="p-2 text-left w-10">#</th>
                                    <th class="p-2 text-left">Nama</th>
                                    <th class="p-2 text-left">Kode</th>
                                    {{-- <th class="p-2 text-left">Status</th>
                                    <th class="p-2 text-left">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($list as $i => $k)
                                    <tr class="border-t">
                                        <td class="p-2">{{ $list->firstItem() + $i }}</td>
                                        <td class="p-2">{{ $k->nama }}</td>
                                        <td class="p-2">{{ $k->kode ?? '-' }}</td>
                                        {{-- <td class="p-2">
                                            @if ($k->aktif)
                                                <span
                                                    class="inline-block px-2 py-1 text-xs rounded bg-emerald-100 text-emerald-700">Aktif</span>
                                            @else
                                                <span
                                                    class="inline-block px-2 py-1 text-xs rounded bg-slate-100 text-slate-700">Nonaktif</span>
                                            @endif
                                        </td> --}}
                                        {{-- <td class="p-2 flex gap-2">
                                            <a href="{{ route('kategori-pengaduan.edit', $k->id) }}"
                                                class="px-3 py-1.5 rounded bg-sky-600 hover:bg-sky-700 text-white text-sm">Edit</a>

                                            <form method="POST"
                                                action="{{ route('kategori-pengaduan.destroy', $k->id) }}"
                                                onsubmit="return confirm('Hapus {{ $k->nama }}?')">
                                                @csrf @method('DELETE')
                                                <button
                                                    class="px-3 py-1.5 rounded bg-rose-600 hover:bg-rose-700 text-white text-sm">Hapus</button>
                                            </form>

                                            <form method="POST"
                                                action="{{ route('kategori-pengaduan.toggle', $k->id) }}">
                                                @csrf @method('PATCH')
                                                <button
                                                    class="px-2 py-1 rounded text-xs {{ $k->aktif ? 'bg-slate-100 text-slate-700' : 'bg-emerald-100 text-emerald-700' }}">
                                                    {{ $k->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="p-3 text-center" colspan="5">Belum ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $list->links() }}</div>
                </div>

            </div>
        </div>

        @include('components.alert')
    </div>
</x-layout>
