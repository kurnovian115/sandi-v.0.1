@props(['href', 'current' => false, 'ariaCurrent' => false])

@php
    $ariaCurrent = $current ? 'page' : false;
@endphp

<a href="{{ $href }}" aria-current="{{ $ariaCurrent }}" @class([
    // base
    'text-sm flex items-center w-full p-2 pl-6 rounded-md transition',
    'dark:text-white',

    // inactive
    '!bg-transparent hover:bg-gray-100 dark:hover:bg-gray-700' => !$current,

    // active (lebih kontras)
    'bg-blue-800 text-white font-semibold ring-1 ring-blue-400/20' => $current,
    // 'bg-gray-200 dark:bg-gray-800 text-gray-900 font-semibold ring-1 ring-gray-200/70 dark:ring-white/10' => $current,
])>
    {{ $slot }}
</a>
