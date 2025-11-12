<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sandi Jabar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">


</head>

<body>
    @include('components.alert')

    {{-- <x-navbar :title='$title'></x-navbar> --}}
    {{-- Sidebar (fixed). Dipilih berdasarkan role user yang login --}}
    {{-- Sidebar berdasarkan role --}}
    @auth
        @php($role = optional(Auth::user()->role)->name)

        @switch($role)
            @case('admin_kanwil')
                <x-sidebar.kanwil />
            @break

            @case('admin_upt')
                <x-sidebar.upt />
            @break

            @case('admin_layanan')
                <x-sidebar.layanan />
            @break
        @endswitch
    @endauth

    <x-header :title='$title'></x-header>
    <main>
        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 mt-14">
                {{ $slot }}
            </div>
        </div>
</body>

</html>
