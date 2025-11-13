<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SANDI JABAR — Sarana Pengaduan Imigrasi Jawa Barat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png" />
</head>

<body class="min-h-screen bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-100">
    <!-- HEADER -->
    <!-- HEADER (ganti seluruh header lama dengan ini) -->
    <header class="sticky top-0 z-30 w-full h-16 border-b border-blue-800/20 bg-blue-700 text-white/95 backdrop-blur">
        <nav class="mx-auto flex h-full max-w-screen-xl items-center justify-between px-4 sm:px-5 md:px-6">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Imigrasi Jawa Barat"
                    class="h-9 w-9 rounded-xl md:h-10 md:w-10" />
                <div class="leading-tight">
                    <p class="text-[10px] md:text-xs uppercase tracking-widest">Sarana Pengaduan</p>
                    <p class="text-base md:text-lg font-extrabold">SANDI JABAR</p>
                </div>
            </a>

            <!-- Desktop CTAs + Auth controls -->
            <div class="hidden items-center gap-3 md:flex">
                <a href="{{ route('pengaduan.create') }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-white px-4 py-2 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50 focus:outline-none focus-visible:ring focus-visible:ring-white/50">
                    Buat Pengaduan
                </a>

                <a href="{{ route('pengaduan.track') }}"
                    class="inline-flex items-center justify-center rounded-2xl border border-white/70 bg-transparent px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-white/10 focus:outline-none focus-visible:ring focus-visible:ring-white/40">
                    Lacak Pengaduan
                </a>

                {{-- Auth: kalau belum login tampil tombol Login --}}
                @guest
                    <a href="{{ route('login') }}" {{-- class="inline-flex items-center justify-center rounded-2xl border border-white/70 bg-transparent px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-white/10 focus:outline-none focus-visible:ring focus-visible:ring-white/40"> --}}
                        class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-indigo-600 to-sky-500 px-4 py-2 text-sm font-semibold text-white shadow-md transition hover:from-indigo-700 hover:to-sky-600">
                        <!-- icon login -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"
                            aria-hidden="true">
                            <path d="M10 17l5-5-5-5v10zM5 19h2V5H5v14z" />
                        </svg>
                        <span class="ml-2">Login</span>
                    </a>
                @endguest

                {{-- Authenticated: tampilkan nama + dropdown kecil menuju dashboard & logout --}}
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button id="profile-toggle"
                            class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-2 text-sm font-medium text-white hover:bg-white/15 focus:outline-none focus-visible:ring focus-visible:ring-white/40"
                            aria-haspopup="true" aria-expanded="false" type="button">
                            <span
                                class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-600 text-xs font-semibold">
                                {{ strtoupper(mb_substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </span>
                            <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.12 1l-4.25 4.657a.75.75 0 01-1.12 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- dropdown -->
                        <div id="profile-menu"
                            class="absolute right-0 mt-2 w-48 origin-top-right rounded-lg bg-white text-gray-800 shadow-lg ring-1 ring-black/5 hidden"
                            role="menu" aria-orientation="vertical" aria-labelledby="profile-toggle">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-50"
                                role="menuitem">Dashboard</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            <!-- Mobile Toggle -->
            <div class="flex items-center gap-2 md:hidden">
                <!-- small Login button visible on mobile when guest -->
                {{-- @guest
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-sky-500 px-3 py-2 text-sm font-semibold text-white">
                        Login
                    </a>
                @endguest --}}

                <button aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-menu"
                    data-toggle="mobile-menu"
                    class="inline-flex items-center gap-2 rounded-xl border border-white/40 bg-white/10 p-2 text-sm focus:outline-none focus-visible:ring focus-visible:ring-white/50">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path d="M3.75 5.25h16.5v1.5H3.75zM3.75 11.25h16.5v1.5H3.75zM3.75 17.25h16.5v1.5H3.75z" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden border-t border-white/20 bg-blue-700 px-4 py-3 md:hidden">
            <div class="flex flex-col gap-2">
                <a href="{{ route('pengaduan.create') }}"
                    class="w-full rounded-2xl bg-white px-4 py-3 text-center text-sm font-semibold text-blue-700 hover:bg-blue-50">Buat
                    Pengaduan</a>

                <a href="{{ route('pengaduan.track') }}"
                    class="w-full rounded-2xl border border-white/40 bg-transparent px-4 py-3 text-center text-sm font-semibold text-white hover:bg-white/10">Lacak
                    Pengaduan</a>

                @guest
                    <a href="{{ route('login') }}"
                        class="w-full rounded-2xl bg-gradient-to-r from-indigo-600 to-sky-500 px-4 py-3 text-center text-sm font-semibold text-white">Login</a>
                @endguest

                @auth
                    <a href="{{ route('dashboard') }}"
                        class="w-full rounded-2xl bg-white px-4 py-3 text-center text-sm font-semibold text-blue-700">Dashboard</a>

                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full rounded-2xl border border-white/40 bg-transparent px-4 py-3 text-center text-sm font-semibold text-white">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </header>


    <!-- Background gradient (biru–putih–kuning) + pola titik -->
    <div aria-hidden="true" class="pointer-events-none fixed inset-0 -z-10">
        <!-- Layer 1: gradient halus biru-putih-kuning -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-100 via-white to-yellow-100"></div>
        <!-- Layer 2: pola titik tipis -->
        <div class="absolute inset-0"
            style="background-image: radial-gradient(circle at 1px 1px, rgba(30,58,138,.10) 1px, transparent 0); background-size: 22px 22px;">
        </div>
    </div>

    <!-- HERO -->
    <section class="relative overflow-hidden mt-10 py-5 sm:py-6 md:py-6">
        <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 sm:px-6 md:grid-cols-2 md:gap-10">
            <!-- Teks -->
            <div class="order-2 md:order-1 text-center md:text-left">
                <div
                    class="mb-2 inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[11px] font-medium text-blue-800 dark:border-blue-900/40 dark:bg-blue-950/40 dark:text-blue-200">
                    <span class="inline-block h-2 w-2 rounded-full bg-blue-600"></span>
                    Layanan Resmi Kanwil Ditjenim Jawa Barat
                </div>

                <h1 class="mb-4 text-center md:text-left text-3xl font-extrabold leading-tight sm:text-3xl md:text-4xl">
                    <span class="text-blue-700 dark:text-blue-300">Sarana Pengaduan Imigrasi </br>Jawa Barat</span>
                </h1>

                <p
                    class="mb-6 text-center md:text-left max-w-2xl text-base text-gray-700 sm:text-lg dark:text-gray-300">
                    Sampaikan keluhan, saran, atau pertanyaan anda terkait layanan keimigrasian di Jawa Barat. Kami
                    memastikan tindak lanjut yang jelas, transparan, dan cepat.
                </p>

                <div class="flex flex-wrap justify-center md:justify-start gap-3">
                    <a href="{{ route('pengaduan.create') }}"
                        class="inline-flex items-center gap-2 rounded-2xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:translate-y-0.5 hover:bg-blue-800 focus:outline-none focus-visible:ring focus-visible:ring-blue-300 dark:focus-visible:ring-blue-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="h-5 w-5">
                            <path
                                d="M12 4.5a.75.75 0 01.75.75v6h6a.75.75 0 010 1.5h-6v6a.75.75 0 01-1.5 0v-6h-6a.75.75 0 010-1.5h6v-6A.75.75 0 0112 4.5z" />
                        </svg>
                        Buat Pengaduan
                    </a>
                    <a href="{{ route('pengaduan.track') }}"
                        class="inline-flex items-center gap-2 rounded-2xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 shadow-sm transition hover:translate-y-0.5 hover:bg-gray-50 focus:outline-none focus-visible:ring focus-visible:ring-blue-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="h-5 w-5">
                            <path
                                d="M10.5 3.75A6.75 6.75 0 1021 14.25a.75.75 0 10-1.5 0 5.25 5.25 0 11-5.25-5.25.75.75 0 000-1.5A6.75 6.75 0 0010.5 3.75zM21 21a.75.75 0 01-1.06 0l-3.72-3.72a.75.75 0 111.06-1.06L21 19.94A.75.75 0 0121 21z" />
                        </svg>
                        Lacak Pengaduan
                    </a>
                </div>

                <!-- Alur Singkat -->
                <div class="mt-8 text-center md:text-left">
                    <h3 class="mb-3 text-sm font-semibold tracking-wide text-blue-900/80 dark:text-blue-300">Alur
                        Singkat Pengaduan</h3>
                    <div class="grid max-w-2xl mx-auto md:mx-0 grid-cols-1 gap-4 sm:grid-cols-3">
                        <div
                            class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-800/60">
                            <div
                                class="mb-2 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white">
                                1</div>
                            <p class="mb-1 font-semibold">Kirim</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Isi formulir & lampiran (jika ada).</p>
                        </div>
                        <div
                            class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-800/60">
                            <div
                                class="mb-2 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white">
                                2</div>
                            <p class="mb-1 font-semibold">Proses & Verifikasi</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Ditelaah dan ditindaklanjuti.</p>
                        </div>
                        <div
                            class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-800/60">
                            <div
                                class="mb-2 inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white">
                                3</div>
                            <p class="mb-1 font-semibold">Pantau Status</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Gunakan fitur <em>Lacak Pengaduan</em>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gambar -->
            <div class="relative order-1 md:order-2 md:col-start-2 md:self-center">
                <div
                    class="absolute -inset-6 -z-10 rounded-3xl bg-gradient-to-tr from-blue-200/60 via-transparent to-transparent blur-2xl dark:from-blue-900/30">
                </div>
                <img class="w-full rounded-3xl border border-gray-200 shadow-2xl dark:border-gray-800"
                    src="{{ asset('images/hero.png') }}" alt="Ilustrasi pengaduan layanan keimigrasian" />
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="mt-8 border-t ">
        <div
            class="mx-auto max-w-7xl px-4 sm:px-6 py-4 flex flex-col md:flex-row items-center justify-center md:justify-between text-center text-sm text-gray-600 dark:text-gray-300 gap-2">
            <p class="font-semibold text-gray-700 dark:text-gray-200">SANDI JABAR — Sarana Pengaduan Imigrasi Jawa
                Barat
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">© {{ date('Y') }} Kantor Wilayah Direktorat
                Jenderal
                Imigrasi Jawa
                Barat</p>
        </div>
    </footer>

    <script>
        // mobile menu toggle (sudah ada di file lama — pastikan ini tetap ada)
        const btn = document.querySelector('[data-toggle="mobile-menu"]');
        const menu = document.getElementById('mobile-menu');
        if (btn && menu) {
            btn.addEventListener('click', () => {
                const isHidden = menu.classList.toggle('hidden');
                btn.setAttribute('aria-expanded', String(!isHidden));
            });
        }

        // profile dropdown handling (desktop)
        document.addEventListener('click', function(e) {
            const toggle = document.getElementById('profile-toggle');
            const menuProfile = document.getElementById('profile-menu');

            if (!toggle || !menuProfile) return;

            // click on toggle -> toggle menu
            if (toggle.contains(e.target)) {
                const isHidden = menuProfile.classList.toggle('hidden');
                toggle.setAttribute('aria-expanded', String(!isHidden));
                return;
            }

            // click outside -> hide
            if (!menuProfile.contains(e.target)) {
                menuProfile.classList.add('hidden');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });

        // optional: close profile menu on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const menuProfile = document.getElementById('profile-menu');
                const toggle = document.getElementById('profile-toggle');
                if (menuProfile && !menuProfile.classList.contains('hidden')) {
                    menuProfile.classList.add('hidden');
                    if (toggle) toggle.setAttribute('aria-expanded', 'false');
                }
            }
        });
    </script>

</body>

</html>
