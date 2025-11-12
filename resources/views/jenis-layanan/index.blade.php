<x-layout :title="$title ?? 'Jenis Layanan Pengaduan'">
    <div class="max-w-6xl mx-auto px-4 lg:px-0" x-data="{ openAdd: false }">

        {{-- HEADER --}}
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h1 class="text-lg font-semibold">Jenis Layanan Pengaduan</h1>
                        <p class="text-xs text-indigo-100/90">Kelola daftar jenis layanan untuk disposisi & monitoring.
                        </p>
                    </div>

                    <a href="/jenis-layanan/tambah"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                        </svg>
                        Tambah Layanan
                    </a>
                </div>
            </div>

            {{-- FILTER BAR (mobile-first, rapi) --}}
            <div class="px-6 py-4 border-b border-slate-200 bg-white">
                <form method="GET"
                    class="max-w-4xl mx-auto flex flex-col gap-2 lg:flex-row lg:flex-wrap lg:items-center lg:justify-center lg:gap-2">

                    {{-- Search + Cari (responsif) --}}
                    <div class="w-full lg:w-auto lg:flex lg:items-stretch gap-0">
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="Cari nama / NIP / email"
                            class="w-full rounded-lg lg:rounded-l-lg lg:rounded-r-none border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">

                        {{-- Tombol cari --}}
                        <button type="submit"
                            class="cursor-pointer mt-2 w-full lg:mt-0 lg:w-auto flex items-center justify-center gap-2 rounded-lg lg:rounded-r-lg lg:rounded-l-none bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 text-sm font-medium transition">
                            <i class="bi bi-search"></i>
                            <span>Cari</span>
                        </button>
                    </div>

                    {{-- Filter Status --}}
                    <div class="relative w-full lg:w-48">
                        <select name="status"
                            class="w-full appearance-none rounded-lg border border-slate-300 px-3 pr-9 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Status</option>
                            <option value="active" @selected(request('status') === 'active')>Aktif</option>
                            <option value="inactive" @selected(request('status') === 'inactive')>Nonaktif</option>
                        </select>
                        <i
                            class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>

                    {{-- Terapkan & Reset --}}
                    <button type="submit"
                        class="cursor-pointer w-full lg:w-auto inline-flex items-center justify-center gap-1 rounded-lg bg-sky-600 hover:bg-sky-700 text-white px-3 py-2 text-sm">
                        <i class="bi bi-funnel"></i> Terapkan
                    </button>

                    <a href="{{ route('jenis-layanan.index') }}"
                        class="w-full lg:w-auto inline-flex items-center justify-center gap-1 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-800 px-3 py-2 text-sm">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </form>
                <x-jenis-layanan.table :list="$list" />
            </div>

</x-layout>
