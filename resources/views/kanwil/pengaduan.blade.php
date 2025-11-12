<x-layout :title="$title ?? 'Semua Pengaduan'">

    <div class="space-y-4">

        {{-- Header --}}
        <div class="flex flex-wrap justify-between items-center">
            <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-200">
                Semua Pengaduan
            </h1>

            <form method="GET" class="flex flex-wrap items-center gap-2">
                {{-- Filter Kategori --}}
                <select name="kategori"
                    class="text-sm rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}" @selected(request('kategori') == $k->id)>
                            {{ $k->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Status --}}
                <select name="status"
                    class="text-sm rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    @foreach (['menunggu', 'proses', 'selesai', 'ditolak'] as $s)
                        <option value="{{ $s }}" @selected(request('status') == $s)>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Prioritas --}}
                <select name="prioritas"
                    class="text-sm rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Prioritas</option>
                    @foreach (['rendah', 'sedang', 'tinggi', 'kritikal'] as $p)
                        <option value="{{ $p }}" @selected(request('prioritas') == $p)>
                            {{ ucfirst($p) }}
                        </option>
                    @endforeach
                </select>

                <x-primary-button>
                    <i class="bi bi-funnel"></i> Filter
                </x-primary-button>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-lg shadow border border-gray-200 bg-white">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-blue-950 text-slate-100 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">No Tiket</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">UPT</th>
                        <th class="px-4 py-3">Pelapor</th>
                        <th class="px-4 py-3">Prioritas</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengaduans as $p)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-2 font-medium text-gray-800">
                                {{ $p->no_tiket }}
                            </td>
                            <td class="px-4 py-2 text-gray-500">
                                {{ $p->created_at->format('d M Y') }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $p->kategori->name ?? '-' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $p->unit->name ?? '-' }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $p->pelapor->name ?? '-' }}
                            </td>
                            <td class="px-4 py-2">
                                <span
                                    class="px-2 py-1 text-xs rounded-md
                                    @class([
                                        'bg-green-100 text-green-800' => $p->prioritas == 'rendah',
                                        'bg-yellow-100 text-yellow-800' => $p->prioritas == 'sedang',
                                        'bg-orange-100 text-orange-800' => $p->prioritas == 'tinggi',
                                        'bg-red-100 text-red-800' => $p->prioritas == 'kritikal',
                                    ])">
                                    {{ ucfirst($p->prioritas) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <span
                                    class="px-2 py-1 text-xs rounded-md
                                    @class([
                                        'bg-gray-200 text-gray-800' => $p->status == 'menunggu',
                                        'bg-blue-100 text-blue-800' => $p->status == 'proses',
                                        'bg-green-100 text-green-800' => $p->status == 'selesai',
                                        'bg-red-100 text-red-800' => $p->status == 'ditolak',
                                    ])">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex justify-center gap-2">
                                    {{-- Detail --}}
                                    <a href="{{ route('kanwil.pengaduan.show', $p->id) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-md border
              border-slate-200 text-slate-700 hover:bg-slate-50"
                                        title="Detail" aria-label="Detail">
                                        {{-- eye --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 16 16"
                                            fill="currentColor">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8" />
                                            <path fill="#fff" d="M8 5.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z" />
                                        </svg>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('kanwil.pengaduan.edit', $p->id) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-md border
              border-slate-200 text-slate-700 hover:bg-slate-50"
                                        title="Edit" aria-label="Edit">
                                        {{-- pencil --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 16 16"
                                            fill="currentColor">
                                            <path
                                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-9.5 9.5L3 14l.646-3.354z" />
                                            <path d="M11.207 2.5 13.5 4.793l-1 1L10.207 3.5z" />
                                        </svg>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('kanwil.pengaduan.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus pengaduan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-md border
               border-rose-200 text-rose-700 hover:bg-rose-50"
                                            title="Hapus" aria-label="Hapus">
                                            {{-- trash --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 16 16"
                                                fill="currentColor">
                                                <path
                                                    d="M5.5 5.5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m5 0a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5" />
                                                <path
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2h13zM4 4v9a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-4">
                                Tidak ada data pengaduan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $pengaduans->links() }}
        </div>
    </div>

</x-layout>
