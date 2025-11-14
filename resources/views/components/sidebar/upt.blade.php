<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full 
           bg-blue-950 border-r border-blue-900 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-blue-950">
        <div data-accordion="collapse" id="sidebar-accordion" class="space-y-2 font-medium text-slate-200">

            {{-- BERANDA --}}
            <li>
                {{-- {{ route('upt.dashboard') }} --}}

                <x-nav-link href="{{ route('upt.beranda.index') }} " :current="request()->routeIs('upt.beranda.index')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-house-door-fill" viewBox="0 0 16 16">
                        <path
                            d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5" />
                    </svg>
                    <span class="flex-1 ms-1 whitespace-nowrap text-slate-200">Dashboard</span>
                </x-nav-link>
            </li>

            <li>
                <x-nav-link href="/admin-layanan" :current="request()->is('admin-layanan')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path
                            d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                    </svg>
                    <span class="flex-1 ms-1 whitespace-nowrap text-slate-200">User Layanan</span>
                </x-nav-link>
            </li>


            <li>
                <x-nav-link href="{{ route('upt.disposisi.index') }}" :current="request()->routeIs('upt.disposisi.*')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-inbox-fill" viewBox="0 0 16 16">
                        <path
                            d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4zm-1.17-.437A1.5 1.5 0 0 1 4.98 3h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374z" />
                    </svg>
                    <span class="flex-1 ms-1 whitespace-nowrap text-slate-200">Pengaduan Masuk</span>
                </x-nav-link>
            </li>

            <li>
                <x-nav-link href="{{ route('upt.apresiasi.index') }}" :current="request()->routeIs('upt.apresiasi.*')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path
                            d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <span class="flex-1 ms-1 whitespace-nowrap text-slate-200">Apresiasi Layanan</span>
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
                <li>
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
                            {{-- <li>
                                {{-- {{ route('upt.pengaduan.index') }} 
                                <x-nav-accordion href="{{ route('upt.disposisi.index') }}" :current="request()->routeIs('upt.disposisi.*')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Pengaduan Masuk
                                </x-nav-accordion>
                            </li> --}}

                            <li>
                                {{-- {{ route('upt.pengaduan.create') }} --}}
                                <x-nav-accordion href="{{ route('pengaduan.eksternal.create') }}" :current="request()->routeIs('pengaduan.eksternal.create')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Tambah Pengaduan (Kanal Eksternal)
                                </x-nav-accordion>
                            </li>
                            <li>
                                {{-- {{ route('upt.pengaduan.create') }} --}}
                                <x-nav-accordion href="{{ route('pengaduan.upt') }}" :current="request()->routeIs('pengaduan.upt*')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Semua Pengaduan
                                </x-nav-accordion>
                            </li>


                        </ul>
                    </div>
                </li>

                {{-- MONITORING PENGADUAN --}}
                {{-- <li>
                    <h2>
                        <button type="button" @click="openItem = openItem === 4 ? null : 4"
                            :aria-expanded="openItem === 4"
                            class="flex items-center w-full p-2 text-sm transition duration-75 rounded-lg  text-slate-200 hover:bg-blue-900/30 {{ $openIndex === 4 ? 'bg-blue-900/50 text-white font-semibold' : '' }}">
                            <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M3 13h18v8H3zM3 3h18v8H3z" />
                            </svg>
                            <span class="flex-1 ms-3 text-left whitespace-nowrap">Monitoring Pengaduan</span>
                            <svg class="w-2 h-2 text-slate-400 transform transition-transform duration-300"
                                :class="openItem === 4 ? 'rotate-180 text-blue-300' : ''"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                    </h2>

                    <div x-show="openItem === 4" x-cloak x-transition class="overflow-hidden">
                        <ul class="py-2 space-y-2 ms-5 border-l border-blue-900">
                            <li>
                                <x-nav-accordion href="#" :current="request()->routeIs('upt.monitoring.index')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Semua Pengaduan
                                </x-nav-accordion>
                            </li>
                            <li>
                                <x-nav-accordion href="#" :current="request()->routeIs('upt.monitoring.sla')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    SLA Terlewat
                                </x-nav-accordion>
                            </li>
                            <li>
                                <x-nav-accordion href="#" :current="request()->routeIs('upt.monitoring.prioritas')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Tiket Prioritas
                                </x-nav-accordion>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                {{-- LAPORAN --}}
                {{-- <li>
                    {{-- {{ route('upt.reports.index') }} --}}
                {{-- <x-nav-link href="#" :current="request()->routeIs('upt.reports.*')">
                        <svg class="w-4 h-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 4h16v16H4z" />
                        </svg>
                        <span class="flex-1 ms-1 whitespace-nowrap text-slate-200">Laporan</span>
                    </x-nav-link>
                </li> --}}


            </ul>
        </div>
    </div>
</aside>
