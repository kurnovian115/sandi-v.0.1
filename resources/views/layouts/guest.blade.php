<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sandi Jabar - Pengaduan</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="fixed left-2 bottom-0 pb-4 z-50">
        <a href="{{ url('/') }}" role="button"
            class="inline-flex items-center gap-3 px-4 py-2.5 rounded-full shadow-xl
               bg-gradient-to-r from-indigo-600 to-sky-500 text-white
               hover:brightness-110 hover:scale-105 transition-transform">

            <!-- Ikon selalu muncul -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16"
                aria-hidden="true">
                <path d="M8 .5l6 5V15a1 1 0 0 1-1 1h-3v-4H6v4H3a1 1 0 0 1-1-1V5.5l6-5z" />
            </svg>

            <!-- Teks hanya tampil di sm ke atas -->
            <span class="hidden sm:inline font-medium">
                Kembali ke Beranda
            </span>
        </a>
    </div>
    <div class="relative py-3 sm:max-w-xl sm:mx-auto w-full">
        <!-- background miring -->
        <div
            class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-800 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
        </div>

        <!-- card utama -->
        <div class="relative px-8 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-12">
            <div class="max-w-md mx-auto">

                <!-- Logo -->
                <div class="flex flex-col items-center justify-center mb-6">
                    <x-application-logo class="w-20 h-20 fill-current text-blue-800" />

                </div>

                <!-- Slot (isi halaman login, register, dsb) -->
                <div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

</html>
