<x-layout : title='$title'>
    {{-- HEADER + ACTIONS (versi polished) --}}
    {{-- HEADER (simple) --}}
    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h2 class="text-lg font-semibold text-slate-800">Data UPT / Kantor Imigrasi</h2>
            <p class="text-xs text-slate-500">Daftar Unit Pelaksana Teknis / Kantor Imigrasi di lingkungan Kantor Wilayah
                Direktorat Jenderal Imigrasi Jawa Barat</p>
        </div>

        <div class="flex items-center gap-2">
            {{-- Search (optional) --}}
            <form method="GET" action="" class="hidden md:block">
                <label class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Nama UPT/Kanim"
                        class="pl-9 pr-3 py-2 text-sm w-64 rounded-lg border border-slate-300 bg-white
                 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                    <span class="absolute left-2 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="bi bi-search"></i>
                    </span>
                </label>
            </form>

            {{-- Primary: Tambah --}}
            <a href="/kanwil/upt/tambah"
                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm rounded-lg
             bg-emerald-600 text-white hover:bg-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                </svg> Tambah UPT
            </a>
        </div>
    </div>

    {{-- TABLE --}}
    <x-kanwil.data-upt.table :upts="$upts" />

</x-layout>
