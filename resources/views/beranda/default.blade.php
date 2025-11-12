<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Beranda</h2>
    </x-slot>

    <div class="p-6 bg-white rounded shadow">
        <p>Halo, {{ auth()->user()->name }}!</p>
        <p class="mt-2 text-gray-600">
            Kamu belum memiliki role yang ditentukan untuk halaman beranda tertentu.
            Silakan hubungi administrator untuk mengatur akses kamu.
        </p>
    </div>
</x-app-layout>
