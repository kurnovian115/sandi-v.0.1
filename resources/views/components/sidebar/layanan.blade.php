<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full 
           bg-blue-950 border-r border-blue-900 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-blue-950">
        <div data-accordion="collapse" id="sidebar-accordion" class="space-y-2 font-medium text-slate-200">

            {{-- BERANDA --}}
            <li>
                {{-- {{ route('upt.dashboard') }} --}}

                <x-nav-link href="/layanan/beranda" :current="request()->is('layanan/beranda')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-house-door-fill" viewBox="0 0 16 16">
                        <path
                            d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5" />
                    </svg>
                    <span class="flex-1 ms-1 whitespace-nowrap text-slate-200">Dashboard</span>
                </x-nav-link>
            </li>

            <li>
                <x-nav-link href="{{ route('layanan.pengaduan.inbox.index') }}" :current="request()->routeIs('layanan.pengaduan.inbox*')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-inbox-fill" viewBox="0 0 16 16">
                        <path
                            d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4zm-1.17-.437A1.5 1.5 0 0 1 4.98 3h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374z" />
                    </svg>
                    <span class="flex-1 ms-1 whitespace-nowrap text-slate-200">Pengaduan Masuk</span>
                </x-nav-link>
            </li>

            <li>
                <x-nav-link href="{{ route('layanan.pengaduan.index') }}" :current="request()->routeIs('layanan.pengaduan.index*')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-file-text" viewBox="0 0 16 16">
                        <path
                            d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1z" />
                        <path
                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1" />
                    </svg>
                    <span class="flex-1 ms-1 whitespace-nowrap text-slate-200">Semua Pengaduan</span>
                </x-nav-link>
            </li>

            @php
                $openIndex = null;
                // highlight sesuai route/url
                if (
                    request()->is('pengaduan.eks.*') ||
                    request()->is('upt.pengaduan*') ||
                    request()->is('pengaduan.upt*') ||
                    request()->is('pengaduan*')
                ) {
                    $openIndex = 1;
                }
                // if (request()->is('upt/users*')) {
                //     $openIndex = 2;
                // }
                if (
                    request()->is('kategori-pengaduan*') ||
                    request()->is('jenis-layanan*') ||
                    request()->is('admin-layanan*')
                ) {
                    $openIndex = 3;
                }
                if (request()->is('upt/monitoring*')) {
                    $openIndex = 4;
                }
                if (request()->is('pengaduan.upt*')) {
                    $openIndex = 1;
                }
                if (request()->is('upt/reports*')) {
                    $openIndex = 5;
                }
                if (request()->is('upt/settings*')) {
                    $openIndex = 6;
                }

                $userRole = Auth::user()->role->name ?? null; // sesuaikan jika struktur role berbeda
            @endphp

            <ul x-data="{ openItem: {{ $openIndex ?? 'null' }} }" class="space-y-1">

                {{-- MANAJEMEN PENGGUNA --}}
                {{-- <li>
                    <h2>
                        <button type="button" @click="openItem = openItem === 2 ? null : 2"
                            :aria-expanded="openItem === 2"
                            class="flex items-center w-full p-2 text-sm transition duration-75 rounded-lg text-slate-200 hover:bg-blue-900/30 {{ $openIndex === 2 ? 'bg-blue-900/50 text-white font-semibold' : '' }}">
                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5..." />
                            </svg>
                            <span class="flex-1 ms-3 text-left whitespace-nowrap">Manajemen Pengguna</span>
                            <svg class="w-2 h-2 text-slate-400 transform transition-transform duration-300"
                                :class="openItem === 2 ? 'rotate-180 text-blue-300' : ''"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                    </h2>

                    <div x-show="openItem === 2" x-cloak x-transition class="overflow-hidden">
                        <ul class="py-2 space-y-2 ms-5 border-l border-blue-900">
                           
                            @if ($userRole === 'kanwil')
                                <li>
                                    <x-nav-accordion href="#" :current="request()->routeIs('kanwil.users.admin-upt.*')"
                                        class="text-slate-300 hover:text-white">
                                        <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                        Admin UPT
                                    </x-nav-accordion>
                                </li>
                            @endif

                            <li>
                                <x-nav-accordion href="#" :current="request()->routeIs('upt.users.petugas.*')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Petugas UPT
                                </x-nav-accordion>
                            </li>

                            <li>
                                <x-nav-accordion href="#" :current="request()->routeIs('upt.users.layanan.*')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    User Layanan
                                </x-nav-accordion>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                {{-- KATEGORI & JENIS LAYANAN --}}
                {{-- <li>
                    <h2>
                        <button type="button" @click="openItem = openItem === 3 ? null : 3"
                            :aria-expanded="openItem === 3"
                            class="flex items-center w-full p-2 text-sm transition duration-75 rounded-lg  text-slate-200 hover:bg-blue-900/30 {{ $openIndex === 3 ? 'bg-blue-900/50 text-white font-semibold' : '' }}">
                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 4h10v3H3zM3 9h10v3H3zM3 14h10v3H3z" />
                            </svg>
                            <span class="flex-1 ms-3 text-left whitespace-nowrap">Master data</span>
                            <svg class="w-2 h-2 text-slate-400 transform transition-transform duration-300"
                                :class="openItem === 3 ? 'rotate-180 text-blue-300' : ''"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                    </h2>

                    <div x-show="openItem === 3" x-cloak x-transition class="overflow-hidden">
                        <ul class="py-2 space-y-2 ms-5 border-l border-blue-900">
                            <li>

                                {{-- {{ route('upt.jenis-layanan.index') 
                                <x-nav-accordion href="/admin-layanan" :current="request()->is('admin-layanan')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Admin Layanan
                                </x-nav-accordion>
                            </li>
                            <li>
                                {{-- {{ route('upt.kategori.index') 
                                <x-nav-accordion href="/kategori-pengaduan" :current="request()->is('kategori-pengaduan')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Kategori Pengaduan
                                </x-nav-accordion>
                            </li>
                            <li>

                                {{-- {{ route('upt.jenis-layanan.index') 
                                <x-nav-accordion href="/jenis-layanan" :current="request()->is('jenis-layanan')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Jenis Layanan
                                </x-nav-accordion>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                {{-- PENGADUAN --}}
                {{-- <li>
                    <h2>
                        <button type="button" @click="openItem = openItem === 1 ? null : 1"
                            :aria-expanded="openItem === 1"
                            class="flex items-center w-full p-2 text-sm transition duration-75 rounded-lg  text-slate-200 hover:bg-blue-900/30 {{ $openIndex === 1 ? 'bg-blue-900/50 text-white font-semibold' : '' }}">
                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 13h18v8H3zM3 3h18v8H3z" />
                            </svg>
                            <span class="flex-1 ms-3 text-left whitespace-nowrap">Pengaduan</span>
                            <svg class="w-2 h-2 text-slate-400 transform transition-transform duration-300"
                                :class="openItem === 1 ? 'rotate-180 text-blue-300' : ''"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                    </h2>

                    <div x-show="openItem === 1" x-cloak x-transition class="overflow-hidden">
                        <ul class="py-2 space-y-2 ms-5 border-l border-blue-900">
                            <li>
                                <x-nav-accordion href="{{ route('pengaduan.eksternal.create') }}" :current="request()->routeIs('pengaduan.eksternal.create')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Tambah Pengaduan (Kanal Eksternal)
                                </x-nav-accordion>
                            </li>
                        </ul>
                    </div>
                </li> --}}


            </ul>
        </div>
    </div>
</aside>
