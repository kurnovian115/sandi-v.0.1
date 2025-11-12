<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full 
           bg-blue-950 border-r border-blue-900 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-blue-950">
        <div data-accordion="collapse" id="sidebar-accordion" class="space-y-2 font-medium text-slate-200">
            <!-- BERANDA -->
            <li>
                <x-nav-link href="/kanwil/beranda" :current="request()->is('kanwil/beranda')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-speedometer" viewBox="0 0 16 16">
                        <path
                            d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z" />
                        <path fill-rule="evenodd"
                            d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.95 11.95 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0" />
                    </svg>
                    <span class="flex-1 ms-1 whitespace-nowrap text-slate-200">Dashboard</span>
                </x-nav-link>
            </li>

            @php
                $openIndex = null;
                if (request()->is('kanwil/upt*')) {
                    $openIndex = 1;
                } elseif (request()->is('admin-layanan*') || request()->is('kanwil/users/admin-upt*')) {
                    $openIndex = 2;
                } elseif (request()->is('kategori-pengaduan*') || request()->is('jenis-layanan*')) {
                    $openIndex = 3;
                } elseif (request()->is('pengaduan*')) {
                    $openIndex = 4;
                } elseif (request()->is('kanwil/evaluasi*')) {
                    $openIndex = 5;
                } elseif (request()->is('kanwil/laporan*')) {
                    $openIndex = 6;
                } elseif (request()->is('kanwil/pengaturan*')) {
                    $openIndex = 7;
                }
            @endphp

            <ul x-data="{ openItem: {{ $openIndex ?? 'null' }} }" class="space-y-1">

                <!-- MANAJEMEN UPT -->
                <li>
                    <x-nav-link href="/kanwil/upt" :current="request()->is('kanwil/upt')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-building-fill" viewBox="0 0 16 16">
                            <path
                                d="M3 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h3v-3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V16h3a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm1 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5M4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5" />
                        </svg>
                        <span class="flex-1 ms-1 whitespace-nowrap text-slate-200">Data UPT</span>
                    </x-nav-link>
                </li>

                <!-- MANAJEMEN PENGGUNA -->
                <li>
                    <h2>
                        <button type="button" @click="openItem = openItem === 2 ? null : 2"
                            :aria-expanded="openItem === 2"
                            class="flex items-center w-full p-2 text-sm transition duration-75 rounded-lg text-slate-200 hover:bg-blue-900/30 {{ $openIndex === 2 ? 'bg-blue-900/50 text-white font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-4 h-4 text-slate-400">
                                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm-9 9a9 9 0 0 1 18 0Z" />
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
                            <li>
                                <x-nav-accordion href="{{ route('kanwil.users.admin-upt.index') }}" :current="request()->routeIs('kanwil.users.admin-upt.*')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon">
                                        <i class="bi bi-dash text-slate-400"></i>
                                    </x-slot>
                                    Admin UPT
                                </x-nav-accordion>
                            </li>
                            <li>
                                <x-nav-accordion href="/admin-layanan" :current="request()->is('admin-layanan')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Admin Layanan
                                </x-nav-accordion>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- KATEGORI & JENIS LAYANAN -->
                <li>
                    <h2>
                        <button type="button" @click="openItem = openItem === 3 ? null : 3"
                            :aria-expanded="openItem === 3"
                            class="flex items-center w-full p-2 text-sm transition duration-75 rounded-lg text-slate-200 hover:bg-blue-900/30 {{ $openIndex === 3 ? 'bg-blue-900/50 text-white font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4 text-slate-400">
                                <path d="M3 4h10v3H3zM3 9h10v3H3zM3 14h10v3H3z" />
                            </svg>
                            <span class="flex-1 ms-3 text-left whitespace-nowrap">Kategori & Jenis Layanan</span>
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
                                <x-nav-accordion href="/kategori-pengaduan" :current="request()->is('kategori-pengaduan')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Kategori Pengaduan
                                </x-nav-accordion>
                            </li>
                            <li>
                                <x-nav-accordion href="/jenis-layanan" :current="request()->is('jenis-layanan')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Jenis Layanan
                                </x-nav-accordion>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- MONITORING PENGADUAN -->
                <li>
                    <h2>
                        <button type="button" @click="openItem = openItem === 4 ? null : 4"
                            :aria-expanded="openItem === 4"
                            class="flex items-center w-full p-2 text-sm transition duration-75 rounded-lg
                       text-slate-200 hover:bg-blue-900/30
                       {{ $openIndex === 4 ? 'bg-blue-900/50 text-white font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" viewBox="0 0 24 24"
                                fill="currentColor">
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
                                <x-nav-accordion href="{{ route('pengaduan.index') }}" :current="request()->is('pengaduan*')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Semua Pengaduan
                                </x-nav-accordion>
                            </li>
                            {{-- <li>
                                <x-nav-accordion href="/kanwil/pengaduan/sla-terlewat" :current="request()->is('kanwil/pengaduan/sla-terlewat')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    SLA Terlewat
                                </x-nav-accordion>
                            </li> --}}
                            {{-- <li>
                                <x-nav-accordion href="/kanwil/pengaduan/prioritas" :current="request()->is('kanwil/pengaduan/prioritas')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Tiket Prioritas
                                </x-nav-accordion>
                            </li> --}}
                        </ul>
                    </div>
                </li>

        </div>
    </div>
</aside>
