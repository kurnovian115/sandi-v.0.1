{{-- TABLE (rapi, border grid, tidak dobel, tombol rapi) --}}
<div class="overflow-x-auto rounded-xl border border-slate-200 shadow-sm mt-4">
    <table class="min-w-full border-collapse text-sm">
        {{-- HEADER --}}
        <thead class="bg-slate-100">
            <tr class="text-slate-700 font-semibold">
                <th class="border border-slate-200 px-4 py-3 text-left align-middle">#</th>
                <th class="border border-slate-200 px-4 py-3 text-left align-middle">Nama Layanan</th>
                <th class="border border-slate-200 px-4 py-3 text-left align-middle">Kode</th>
                <th class="border border-slate-200 px-4 py-3 text-left align-middle">Deskripsi</th>
                <th class="border border-slate-200 px-4 py-3 text-center align-middle">Status</th>
                <th class="border border-slate-200 px-4 py-3 text-center align-middle">Aksi</th>
            </tr>
        </thead>

        {{-- BODY --}}
        <tbody>
            @forelse($list as $i => $l)
                <tr class="hover:bg-slate-50 transition">
                    <td class="border border-slate-200 px-4 py-3 text-slate-700 align-middle">
                        {{ $list->firstItem() + $i }}
                    </td>
                    <td class="border border-slate-200 px-4 py-3 text-slate-800 align-middle">
                        {{ $l->nama }}
                    </td>
                    <td class="border border-slate-200 px-4 py-3 text-slate-700 align-middle">
                        {{ $l->kode ?? '-' }}
                    </td>
                    <td class="border border-slate-200 px-4 py-3 text-slate-700 align-middle">
                        {{ $l->deskripsi ?? '-' }}
                    </td>
                    {{-- STATUS (nowrap biar nggak pecah) --}}
                    <td class="border border-slate-200 px-4 py-3 text-center align-middle whitespace-nowrap">
                        @if ($l->is_active)
                            <span
                                class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium rounded-full border border-green-300 bg-green-50 text-green-700">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium rounded-full border border-red-300 bg-red-50 text-red-600">
                                <span class="h-2 w-2 rounded-full bg-rose-500"></span> Nonaktif
                            </span>
                        @endif
                    </td>

                    {{-- AKSI (nowrap + tombol compact + flex-nowrap) --}}
                    <td class="border border-slate-200 px-4 py-3 text-left align-middle whitespace-nowrap">
                        <div class="inline-flex items-center gap-2 flex-nowrap">
                            {{-- Edit --}}
                            <a href="{{ route('jenis-layanan.edit', $l->id) }}"
                                class="inline-flex items-center gap-1.5 px-3 py-1 text-xs rounded-md border border-yellow-300 text-yellow-700 hover:bg-yellow-50 transition font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12.854.146a.5.5 0 0 1 .638.057l2.305 2.305a.5.5 0 0 1-.057.638L4.207 14.93l-3.182.354a.5.5 0 0 1-.548-.547l.354-3.183L12.854.146z" />
                                </svg>
                                Edit
                            </a>

                            {{-- Nonaktifkan --}}
                            {{-- di resources/views/kanwil/users/admin-upt.blade.php (kolom Aksi) --}}
                            @php
                                $btn =
                                    'inline-flex items-center gap-1.5 h-8 px-3 rounded-md border text-xs font-medium transition cursor-pointer';
                                $svg = 'w-3.5 h-3.5';
                            @endphp
                            @if ($l->is_active)
                                {{-- Nonaktifkan --}}
                                <form id="form-nonaktif-{{ $l->id }}"
                                    action="{{ route('jenis-layanan.nonaktif', $l->id) }}" method="POST"
                                    class="inline">
                                    @csrf @method('PUT')
                                    <button type="button"
                                        onclick="confirmNonaktif({{ $l->id }}, @js($l->nama))"
                                        class="{{ $btn }} border-rose-200 text-rose-700 hover:bg-rose-50">
                                        <svg class="{{ $svg }}" viewBox="0 0 16 16" fill="currentColor">
                                            <path
                                                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5.5 3a.5.5 0 0 1 0-1H16v1zM1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1z" />
                                        </svg>
                                        <span>Nonaktifkan</span>
                                    </button>
                                </form>
                            @else
                                {{-- Aktifkan --}}
                                <form id="form-aktifkan-{{ $l->id }}"
                                    action="{{ route('jenis-layanan.aktifkan', $l->id) }}" method="POST"
                                    class="inline">
                                    @csrf @method('PUT')
                                    <button type="button"
                                        onclick="confirmAktifkan({{ $l->id }}, @js($l->nama))"
                                        class="{{ $btn }} border-emerald-200 text-emerald-700 hover:bg-emerald-50">
                                        <svg class="{{ $svg }}" viewBox="0 0 16 16" fill="currentColor">
                                            <path
                                                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm3.97-8.03a.75.75 0 0 0-1.06-1.06L7.477 9.354 5.53 7.408a.75.75 0 1 0-1.06 1.06L6.97 10.97l5-5z" />
                                        </svg>
                                        <span>Aktifkan</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border border-slate-200 px-4 py-6 text-center text-slate-500 text-sm">
                        Tidak ada data admin UPT ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $list->links() }}
</div>
{{-- Alert global (Swal) --}}
@include('components.alert')
{{-- letakkan di bawah halaman (atau di layout) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmNonaktif(id, name) {
        Swal.fire({
            icon: 'warning',
            title: 'Nonaktifkan Layanan?',
            html: `<p class="text-slate-600 text-sm"><b>${name}</b> akan dinonaktifkan.</p>`,
            showCancelButton: true,
            confirmButtonText: 'Ya, Nonaktifkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            reverseButtons: true
        }).then((res) => {
            if (res.isConfirmed) {
                document.getElementById(`form-nonaktif-${id}`).submit();
            }
        });
    }

    function confirmAktifkan(id, name) {
        Swal.fire({
            icon: 'question',
            title: 'Aktifkan kembali?',
            html: `<p class="text-slate-600 text-sm"><b>${name}</b> akan diaktifkan kembali.</p>`,
            showCancelButton: true,
            confirmButtonText: 'Ya, Aktifkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#059669',
            cancelButtonColor: '#6b7280',
            reverseButtons: true
        }).then((res) => {
            if (res.isConfirmed) {
                document.getElementById(`form-aktifkan-${id}`).submit();
            }
        });
    }
</script>
