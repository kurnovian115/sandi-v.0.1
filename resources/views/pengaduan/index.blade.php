<x-layout :title="$title ?? 'Daftar Pengaduan'">
    <div class="max-w-6xl mx-auto px-4 lg:px-0">
        {{-- HEADER --}}
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h1 class="text-lg font-semibold">Daftar Pengaduan</h1>
                        <p class="text-xs text-indigo-100/90">Kelola dan pantau seluruh pengaduan masyarakat. Gunakan
                            pencarian & filter untuk mempermudah penelusuran.</p>
                    </div>

                    {{-- Contoh tombol tambah (opsional) --}}
                    {{-- <a href="{{ route('pengaduan.create') }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm bg-emerald-600 hover:bg-emerald-700 shadow-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Pengaduan
                    </a> --}}
                </div>
            </div>

            {{-- FILTER BAR --}}
            <div class="px-6 py-4 border-b border-slate-200 bg-white">
                <form method="GET"
                    class="max-w-5xl mx-auto flex flex-col gap-2 lg:flex-row lg:flex-wrap lg:items-center lg:justify-center lg:gap-2">

                    {{-- Search --}}
                    <div class="w-full lg:w-auto lg:flex lg:items-stretch gap-0">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari tiket / judul / pelapor"
                            class="w-full rounded-lg lg:rounded-l-lg lg:rounded-r-none border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit"
                            class="cursor-pointer mt-2 w-full lg:mt-0 lg:w-auto flex items-center justify-center gap-2 rounded-lg lg:rounded-r-lg lg:rounded-l-none bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 text-sm font-medium">
                            <i class="bi bi-search"></i>
                            <span>Cari</span>
                        </button>
                    </div>

                    {{-- Filter UPT --}}
                    <div class="relative w-full lg:w-56">
                        <select name="unit_id"
                            class="w-full appearance-none rounded-lg border border-slate-300 px-3 pr-9 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua UPT</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->id }}" @selected(request('unit_id') == $u->id)> {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                        <i
                            class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>

                    {{-- Filter Layanan --}}
                    <div class="relative w-full lg:w-56">
                        <select name="jenis_layanan_id"
                            class="w-full appearance-none rounded-lg border border-slate-300 px-3 pr-9 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Layanan</option>
                            @foreach ($jenisLayanans as $jl)
                                <option value="{{ $jl->id }}" @selected(request('jenis_layanan_id') == $jl->id)>{{ $jl->nama }}
                                </option>
                            @endforeach
                        </select>
                        <i
                            class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>

                    {{-- Filter Status --}}
                    <div class="relative w-full lg:w-56">
                        <select name="status"
                            class="w-full appearance-none rounded-lg border border-slate-300 px-3 pr-9 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Status</option>
                            @foreach ($statuses as $st)
                                <option value="{{ $st }}" @selected(request('status') === $st)>{{ $st }}
                                </option>
                            @endforeach
                        </select>
                        <i
                            class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>

                    {{-- Asal & Rentang Tanggal --}}
                    {{-- <div class="relative w-full lg:w-44">
                        <input type="text" name="asal_pengaduan" value="{{ request('asal_pengaduan') }}"
                            placeholder="Asal pengaduan"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div> --}}


                    <div class="relative w-full lg:w-44">
                        <input type="date" name="from" value="{{ request('from') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="relative w-full lg:w-44">
                        <input type="date" name="to" value="{{ request('to') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Terapkan & Reset --}}
                    <button type="submit"
                        class="cursor-pointer w-full lg:w-auto inline-flex items-center justify-center gap-1 rounded-lg bg-sky-600 hover:bg-sky-700 text-white px-3 py-2 text-sm">
                        <i class="bi bi-funnel"></i> Terapkan
                    </button>
                    <a href="{{ route('pengaduan.index') }}"
                        class="w-full lg:w-auto inline-flex items-center justify-center gap-1 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-800 px-3 py-2 text-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="px-6 py-4 bg-white">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-600 border-b border-slate-200">
                                <th class="py-3 pr-3">Tiket</th>
                                <th class="py-3 pr-3">Dibuat</th>
                                <th class="py-3 pr-3">Asal Pengaduan</th>
                                <th class="py-3 pr-3">Pelapor</th>
                                <th class="py-3 pr-3">UPT</th>
                                {{-- <th class="py-3 pr-3">Layanan</th> --}}
                                <th class="py-3 pr-3">Judul</th>
                                <th class="py-3 pr-3">Status</th>
                                <th class="py-3 pr-0 ">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengaduans as $p)
                                <tr class="border-b border-slate-100">
                                    <td class="py-3 pr-3 text-xs font-medium text-slate-800">{{ $p->no_tiket }}</td>
                                    <td class="py-3 pr-3 text-xs text-slate-600">
                                        {{ optional($p->created_at)->format('d M Y H:i') }}</td>
                                    <td class="py-3 pr-3 text-xs">
                                        <div class="font-medium">
                                            @if ($p->asal_pengaduan)
                                                {{ $p->asal_pengaduan ?: '—' }}
                                            @else
                                                Sandi Jabar
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 pr-3 text-xs">
                                        <div class="font-medium">{{ $p->pelapor_nama ?: '—' }}</div>
                                        <div class="text-xs text-slate-500">{{ $p->pelapor_contact ?: '—' }}</div>
                                    </td>

                                    <td class="py-3 pr-3 text-xs">{{ optional($p->unit)->name ?: '—' }}</td>
                                    {{-- <td class="py-3 pr-3 text-xs">{{ optional($p->jenisLayanan)->nama ?: '—' }}</td> --}}
                                    <td class="py-3 pr-3 text-xs max-w-[280px]">
                                        <div class="line-clamp-2">{{ $p->judul }}</div>
                                    </td>
                                    <td class="py-3 pr-3 text-xs">
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 rounded-full border text-xs {{ $p->status_badge_class }}">{{ $p->status_label }}</span>
                                    </td>
                                    {{-- <td class="py-3 pr-3 text-xs">
                                        @if ($p->sla_due_at)
                                            <div>Jatuh tempo: <span
                                                    class="font-medium">{{ $p->sla_due_at->format('d M Y H:i') }}</span>
                                            </div>
                                            @if ($p->sla_late)
                                                <div class="text-rose-600">Terlambat</div>
                                            @else
                                                <div class="text-emerald-600">On track</div>
                                            @endif
                                        @else
                                            —
                                        @endif
                                    </td> --}}
                                    <td class="py-3 pr-0">
                                        <div class="flex items-center justify-end gap-1">
                                            {{-- {{ route('pengaduan.show', $p->id) }} --}}
                                            <a href="{{ route('pengaduan.show', $p->id) }}"
                                                class="inline-flex text-xs items-center gap-1 px-2 py-1 rounded-md border bg-blue-300 text-blue-800 border-slate-200 hover:bg-slate-50">
                                                <i class="bi bi-eye"></i> Lihat Detail
                                            </a>

                                            {{-- @if ($p->status === \App\Models\Pengaduan::STATUS_MENUNGGU)
                                                {{-- {{ route('pengaduan.disposisi.form', $p->id) }} 
                                                <a href="#"
                                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white">
                                                    <i class="bi bi-send"></i> Disposisi
                                                </a>
                                            @endif

                                            @if ($p->status !== \App\Models\Pengaduan::STATUS_SELESAI)
                                                <form id="finish-{{ $p->id }}" {{-- {{ route('pengaduan.finish', $p->id) }} 
                                                    action="#" method="POST" class="hidden">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                                <button type="button"
                                                    onclick="confirmSelesai('{{ $p->id }}', '{{ $p->no_tiket }}')"
                                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white">
                                                    <i class="bi bi-check2-circle"></i> Tandai Selesai
                                                </button>
                                            @endif --}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-10 text-center text-slate-500">Belum ada data
                                        pengaduan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $pengaduans->links() }}</div>
            </div>
        </div>

        {{-- SweetAlert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmSelesai(id, tiket) {
                Swal.fire({
                    icon: 'question',
                    title: 'Tandai selesai?',
                    html: `Pengaduan <b>${tiket}</b> akan ditandai selesai.`,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, selesai',
                    confirmButtonColor: '#059669',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then(r => {
                    if (r.isConfirmed) document.getElementById(`finish-${id}`).submit()
                })
            }
        </script>

        {{-- Alert global (opsional) --}}
        @include('components.alert')
    </div>
</x-layout>
