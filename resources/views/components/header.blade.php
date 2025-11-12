<nav class="fixed top-0 z-50 w-full bg-blue-800 border-b border-blue-900" x-data="{ open: false }">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-slate-200 rounded-lg sm:hidden hover:bg-blue-900/30 focus:outline-none focus:ring-2 focus:ring-blue-400/40">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" />
                    </svg>
                </button>

                <a href="#" class="flex items-center gap-2 md:gap-3 ms-2 md:me-24 transition-all duration-300">
                    <img src="/images/logo.png" alt="Logo SANDI JABAR" class="w-8 h-8 sm:w-9 sm:h-9 object-contain" />
                    <span class="text-lg sm:text-xl md:text-2xl font-semibold text-white whitespace-nowrap">SANDI
                        JABAR</span>
                </a>
            </div>

            <div class="flex items-center space-x-2">
                @php
                    $name = trim(Auth::user()->name ?? '');
                    $parts = preg_split('/\s+/', $name);
                    $initials = strtoupper(
                        mb_substr($parts[0] ?? '', 0, 1) . (isset($parts[1]) ? mb_substr($parts[1], 0, 1) : ''),
                    );
                @endphp

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="hidden sm:inline-flex items-center gap-2 px-2.5 py-1.5 rounded-lg bg-blue-800/40 hover:bg-blue-700/60 text-white text-sm focus:outline-none transition">
                            {{-- avatar --}}
                            <span
                                class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-indigo-400 text-white text-xs font-semibold flex-shrink-0">
                                {{ $initials ?: 'U' }}
                            </span>

                            {{-- name + role --}}
                            <div class="hidden sm:flex flex-col leading-none whitespace-nowrap text-left">
                                <span class="text-sm font-medium">{{ $name }}</span>
                                <span class="text-[11px] text-slate-300">{{ Auth::user()->role->label }}</span>
                            </div>

                            {{-- chevron --}}
                            <svg class="hidden sm:inline-block h-3.5 w-3.5 text-slate-100"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link class="text-rose-600 hover:text-rose-700"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile-only user button (tombol kecil AW) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-200 hover:text-white hover:bg-blue-900/30 focus:outline-none focus:ring-2 focus:ring-blue-400/40"
                    aria-expanded="false" aria-label="Open user menu">
                    {{-- avatar kecil (inisial) --}}
                    <span
                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-400 text-white text-xs font-semibold">
                        {{ $initials ?? 'U' }}
                    </span>
                </button>
            </div>

        </div>
    </div>

    <!-- PANEL MENU MOBILE -->
    <div class="sm:hidden bg-white border-t border-blue-900/30" x-show="open" x-transition x-cloak
        @click.outside="open = false" style="display:none;">
        <div class="px-4 py-3">
            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
            <div class="text-sm font-medium text-gray-500">NIP. {{ Auth::user()->nip }}</div>
        </div>

        <div class="border-t border-blue-900/20 px-2 py-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</nav>
