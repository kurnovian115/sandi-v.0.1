<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full 
           bg-blue-950 border-r border-blue-900 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-blue-950">
        <div data-accordion="collapse" id="sidebar-accordion" class="space-y-2 font-medium text-slate-200">

            <!-- BERANDA -->
            <li>
                <x-nav-link href="/beranda" :current="request()->is('beranda')">
                    <!-- ikon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-speedometer w-4 h-4 text-slate-400 transition duration-75" viewBox="0 0 16 16">
                        <path
                            d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2M3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707M2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8m9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5m.754-4.246a.39.39 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.39.39 0 0 0-.029-.518z" />
                        <path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78z" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap text-slate-200">Beranda</span>
                </x-nav-link>
            </li>

            @php
                $openIndex = null;
                if (request()->is('was-terbuka') || request()->is('was-tertutup')) {
                    $openIndex = 1;
                } elseif (request()->is('deteni-wna') || request()->is('deteni-pelanggaran')) {
                    $openIndex = 2;
                } elseif (request()->is('pengungsi-mandiri') || request()->is('pengungsi-iom')) {
                    $openIndex = 3;
                } elseif (request()->is('bap-wni') || request()->is('bap-wna')) {
                    $openIndex = 4;
                }
            @endphp

            <ul x-data="{ openItem: {{ $openIndex ?? 'null' }} }" class="space-y-1">

                <!-- PENGAWASAN -->
                <li>
                    <h2>
                        <button type="button" @click="openItem = openItem === 1 ? null : 1"
                            :aria-expanded="openItem === 1"
                            class="flex items-center w-full p-2 text-sm transition duration-75 rounded-lg
                                   text-slate-200 hover:bg-blue-900/30
                                   {{ $openIndex === 1 ? 'bg-blue-900/50 text-white font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="bi bi-shield-shaded w-4 h-4 text-slate-400" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 14.933a1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56" />
                            </svg>

                            <span class="flex-1 ms-3 text-left whitespace-nowrap">Pengawasan</span>

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
                                <x-nav-accordion href="/was-terbuka" :current="request()->is('was-terbuka')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Pengawasan Terbuka
                                </x-nav-accordion>
                            </li>
                            <li>
                                <x-nav-accordion href="/was-tertutup" :current="request()->is('was-tertutup')"
                                    class="text-slate-300 hover:text-white">
                                    <x-slot name="icon"><i class="bi bi-dash text-slate-400"></i></x-slot>
                                    Pengawasan Tertutup
                                </x-nav-accordion>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- DETENI -->
                <li>
                    <h2>
                        <button type="button" @click="openItem = openItem === 2 ? null : 2"
                            :aria-expanded="openItem === 2"
                            class="flex items-center w-full p-2 text-sm transition duration-75 rounded-lg
                                   text-slate-200 hover:bg-blue-900/30
                                   {{ $openIndex === 2 ? 'bg-blue-900/50 text-white font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-4 h-4 text-slate-400">
                                <path fill-rule="evenodd"
                                    d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="flex-1 ms-3 text-left whitespace-nowrap">Deteni</span>
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
                                <x-nav-accordion href="/deteni-wna" :current="request()->is('deteni-wna')"
                                    class="text-slate-300 hover:text-white">
                                    <i class="bi bi-dash text-slate-400"></i> Data WNA
                                </x-nav-accordion>
                            </li>
                            <li>
                                <x-nav-accordion href="/deteni-pelanggaran" :current="request()->is('deteni-pelanggaran')"
                                    class="text-slate-300 hover:text-white">
                                    <i class="bi bi-dash text-slate-400"></i> Pelanggaran
                                </x-nav-accordion>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- PENGUNGSI -->
                <li>
                    <h2>
                        <button type="button" @click="openItem = openItem === 3 ? null : 3"
                            :aria-expanded="openItem === 3"
                            class="flex items-center w-full p-2 text-sm transition duration-75 rounded-lg
                                   text-slate-200 hover:bg-blue-900/30
                                   {{ $openIndex === 3 ? 'bg-blue-900/50 text-white font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4 text-slate-400">
                                <path
                                    d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                            </svg>
                            <span class="flex-1 ms-3 text-left whitespace-nowrap">Pengungsi</span>
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
                                <x-nav-accordion href="/pengungsi-mandiri" :current="request()->is('pengungsi-mandiri')"
                                    class="text-slate-300 hover:text-white">
                                    <i class="bi bi-dash text-slate-400"></i> Mandiri
                                </x-nav-accordion>
                            </li>
                            <li>
                                <x-nav-accordion href="/pengungsi-iom" :current="request()->is('pengungsi-iom')"
                                    class="text-slate-300 hover:text-white">
                                    <i class="bi bi-dash text-slate-400"></i> IOM
                                </x-nav-accordion>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- BAP -->
                <li>
                    <h2>
                        <button type="button" @click="openItem = openItem === 4 ? null : 4"
                            :aria-expanded="openItem === 4"
                            class="flex items-center w-full p-2 text-sm transition duration-75 rounded-lg
                                   text-slate-200 hover:bg-blue-900/30
                                   {{ $openIndex === 4 ? 'bg-blue-900/50 text-white font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-4 h-4 text-slate-400">
                                <path fill-rule="evenodd"
                                    d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                            </svg>
                            <span class="flex-1 ms-3 text-left whitespace-nowrap">Berita Acara Pemeriksaan</span>
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
                                <x-nav-accordion href="/bap-wni" :current="request()->is('bap-wni')"
                                    class="text-slate-300 hover:text-white">
                                    <i class="bi bi-dash text-slate-400"></i> WNI
                                </x-nav-accordion>
                            </li>
                            <li>
                                <x-nav-accordion href="/bap-wna" :current="request()->is('bap-wna')"
                                    class="text-slate-300 hover:text-white">
                                    <i class="bi bi-dash text-slate-400"></i> WNA
                                </x-nav-accordion>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>

        </div>
    </div>
</aside>
