<x-layout :title="$title">
    <div class="max-w-5xl mx-auto px-4 lg:px-0">

        {{-- CARD: header gradient + body + footer --}}
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            {{-- Header --}}
            <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h1 class="text-lg font-semibold">{{ $unit->name }}</h1>
                        <p class="text-xs text-indigo-100/90">Detail Unit Pelaksana Teknis</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($unit->is_active)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-white text-emerald-700 px-2 py-0.5 text-xs shadow-sm">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-white text-rose-700 px-2 py-0.5 text-xs shadow-sm">
                                <span class="h-2 w-2 rounded-full bg-rose-500"></span> Nonaktif
                            </span>
                        @endif

                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-6 py-6">
                {{-- Info grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">


                    <div class="md:col-span-2">
                        <div class="text-[12px] uppercase tracking-wide text-slate-500">Alamat</div>
                        <div class="text-slate-900 font-medium whitespace-pre-line">{{ $unit->address ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-[12px] uppercase tracking-wide text-slate-500">Dibuat</div>
                        <div class="text-slate-900 font-medium">
                            {{ optional($unit->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                        </div>
                    </div>

                    <div>
                        <div class="text-[12px] uppercase tracking-wide text-slate-500">Diperbarui</div>
                        <div class="text-slate-900 font-medium">
                            {{ optional($unit->updated_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>

                {{-- Admin UPT --}}
                <div class="flex items-center gap-3 mb-4">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-xs font-medium
               bg-indigo-50 text-indigo-700 border border-indigo-100">
                        <i class="bi bi-shield-lock"></i> Admin UPT
                    </span>
                    <div class="h-px bg-slate-200 flex-1"></div>
                    <span class="text-xs text-slate-500">{{ $unit->users->count() }} orang</span>
                </div>


                @if ($unit->users->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($unit->users as $admin)
                            <div
                                class="group relative rounded-2xl border border-slate-200 bg-white/80 p-4 shadow-sm hover:shadow-md transition-all duration-200">
                                <div class="flex items-start gap-4">
                                    {{-- Avatar Huruf --}}
                                    <div
                                        class="h-12 w-12 shrink-0 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold text-lg group-hover:bg-indigo-200 transition">
                                        {{ Str::substr($admin->name, 0, 1) }}
                                    </div>

                                    {{-- Data Utama --}}
                                    <div class="flex-1">
                                        <div class="font-semibold text-slate-900 text-base">{{ $admin->name }}</div>
                                        <div class="text-sm text-slate-600">{{ $admin->email ?? '—' }}</div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            NIP: <span
                                                class="font-medium text-slate-700">{{ $admin->nip ?? '—' }}</span>
                                        </div>
                                    </div>

                                    {{-- Badge Role --}}
                                    <span
                                        class="ml-auto rounded-full bg-indigo-50 text-indigo-700 px-2 py-0.5 text-[11px] border border-indigo-100">
                                        Admin UPT
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div
                        class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-4 py-6 text-center text-sm text-slate-600">
                        Belum ada admin untuk UPT ini.
                    </div>
                @endif

            </div>

            {{-- Footer aksi --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-2">
                <a href="{{ route('kanwil.upt.index') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm border border-slate-300 text-slate-700 hover:bg-white">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <a href="{{ url('/kanwil/upt/' . $unit->id . '/edit') }}"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm bg-amber-100 text-amber-800 border border-amber-200 hover:bg-amber-200">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>

                @if ($unit->is_active)
                    <form action="{{ url('/kanwil/upt/' . $unit->id . '/nonaktif') }}" method="POST"
                        onsubmit="return confirm('Nonaktifkan UPT ini?')" class="inline-block">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm bg-rose-100 text-rose-700 border border-rose-200 hover:bg-rose-200">
                            <i class="bi bi-slash-circle"></i> Nonaktifkan
                        </button>
                    </form>
                @else
                    <form action="{{ url('/kanwil/upt/' . $unit->id . '/aktifkan') }}" method="POST"
                        onsubmit="return confirm('Aktifkan kembali UPT ini?')" class="inline-block">
                        @csrf @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm bg-emerald-100 text-emerald-700 border border-emerald-200 hover:bg-emerald-200">
                            <i class="bi bi-check-circle"></i> Aktifkan
                        </button>
                    </form>
                @endif
            </div>
        </div>

    </div>
</x-layout>
