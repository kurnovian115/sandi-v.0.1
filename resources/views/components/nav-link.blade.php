@props(['href', 'current' => false, 'ariaCurrent' => null])

@php
    // Base classes (konsisten untuk semua state)
    $base =
        'flex items-center gap-2 p-2 text-sm rounded-lg transition-colors duration-200 group focus:outline-none focus:ring-2 focus:ring-blue-500/40';

    // Skema warna untuk sidebar gelap bernuansa biru
    $scheme = $current
        ? // Aktif: biru gelap + teks putih + sedikit ring lembut
        'bg-blue-800 text-white font-semibold ring-1 ring-blue-400/20'
        : // Default: teks abu terang, hover jadi kebiruan lembut
        'text-slate-200 hover:bg-blue-900/30 hover:text-white';

    // aria-current hanya saat aktif
    $aria = $current ? 'page' : $ariaCurrent;
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "$base $scheme", 'aria-current' => $aria]) }}>
    {{ $slot }}
</a>
