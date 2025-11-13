<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sandi Jabar - Pengaduan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    {{-- <a href="{{ url('/') }}" class="flex items-center gap-3">
        <img src="/images/logo.png" alt="Logo SANDI JABAR" class="w-8 h-8 object-contain" />
        <span class="text-white text-lg font-semibold">SANDI JABAR</span>
    </a> --}}
</head>

<body class="relative min-h-screen bg-gray-900 overflow-x-hidden">


    <!-- Background logo transparan + overlay gradasi putih lembut -->
    <div class="absolute inset-0 bg-linear-to-b from-white/90 via-white/95 to-white pointer-events-none">

    </div>
    <!-- Header sederhana dengan tombol Lacak Tiket -->
    <nav class="fixed top-0 z-50 w-full bg-blue-800 border-b border-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-3">
                        <img src="/images/logo.png" alt="Logo SANDI JABAR" class="w-8 h-8 object-contain" />
                        <span class="text-white text-lg font-semibold">SANDI JABAR</span>
                    </a>
                </div>

                <!-- Tombol Lacak Tiket -->
                <a href="{{ route('pengaduan.track') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-sky-500  text-white text-sm font-medium shadow-sm hover:from-indigo-700 hover:to-sky-600 transition-all duration-200">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                    <span>Lacak Tiket</span>
                </a>


            </div>
        </div>
    </nav>
    <!-- Konten utama -->
    <main class="relative z-10 pt-24 pb-12">
        <div class="fixed left-2 bottom-0 pb-4 pointer-events-none">
            <a href="{{ url('/') }}" role="button"
                class="inline-flex items-center gap-3 px-4 py-2.5 rounded-full shadow-xl bg-gradient-to-r from-indigo-600 to-sky-500 text-white hover:brightness-110 hover:scale-105 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16"
                    aria-hidden="true">
                    <path d="M8 .5l6 5V15a1 1 0 0 1-1 1h-3v-4H6v4H3a1 1 0 0 1-1-1V5.5l6-5z" />
                </svg>
                Kembali ke Beranda
                <!-- ikoKembali kn + teks -->
            </a>
        </div>

        <div class="max-w-3xl mx-auto px-4">
            <div class="rounded-2xl overflow-hidden shadow border border-slate-200 bg-white/95 backdrop-blur-sm">

                <!-- Header kecil + judul -->
                <header class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                    <h1 class="text-xl font-semibold">{{ __('pengaduan.title') }}</h1>
                    <p class="text-sm text-indigo-100/90 mt-1">{{ __('pengaduan.desc') }}</p>
                </header>

                <!-- Language switch di atas form -->
                <div class="px-6 py-3 bg-slate-50 border-b border-slate-200 text-sm flex justify-end gap-3">
                    <a href="{{ route('lang.switch', 'id') }}"
                        class="{{ app()->getLocale() === 'id' ? 'font-semibold text-indigo-600' : 'text-slate-500' }}">🇮🇩
                        Indonesia</a>
                    <span class="text-slate-300">|</span>
                    <a href="{{ route('lang.switch', 'en') }}"
                        class="{{ app()->getLocale() === 'en' ? 'font-semibold text-indigo-600' : 'text-slate-500' }}">🇬🇧
                        English</a>
                </div>

                <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data"
                    class="px-6 py-6">
                    @csrf

                    {{-- @if (session('ok'))
                        <div class="rounded-md bg-emerald-50 border border-emerald-200 p-3 text-emerald-800 mb-4">
                            {{ session('ok') }}</div>
                    @endif --}}

                    @if (session('ok'))
                        <div class="rounded-md bg-emerald-50 border border-emerald-200 p-3 text-emerald-800 mb-4">
                            {!! session('ok') !!} {{-- optional inline fallback --}}
                        </div>
                    @endif

                    {{-- <input type="hidden" name="asal_pengaduan" value="{{ $source ?? 'qr' }}"> --}}

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-slate-700">{{ __('pengaduan.office_imigration') }}
                                <span class="text-rose-500">*</span></label>
                            <select name="upt_id"
                                class="mt-1 w-full border rounded-lg px-3  py-2 text-sm focus:ring-2 focus:ring-indigo-300">
                                <option value="">{{ __('pengaduan.select_upt') }}</option>
                                @foreach ($upt as $l)
                                    <option value="{{ $l->id }}" @selected(old('upt_id') == $l->id)>
                                        {{ $l->name }}</option>
                                @endforeach
                            </select>
                            @error('upt_id')
                                <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- nama --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700">{{ __('pengaduan.reporter_name') }}
                                <span class="text-rose-500">*</span></label>
                            </label>
                            <input type="text" name="pelapor_nama" value="{{ old('pelapor_nama') }}"
                                class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300"
                                placeholder="{{ __('pengaduan.full_name') }}">
                            @error('pelapor_nama')
                                <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    {{-- Email & NO HP --}}
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">{{ __('pengaduan.contact') }}
                                <span class="text-rose-500">*</span></label>
                            </label>
                            <input type="text" name="pelapor_contact" value="{{ old('pelapor_contact') }}"
                                inputmode="numeric" pattern="[0-9]*" maxlength="13"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300"
                                placeholder="{{ __('pengaduan.contact_name') }}">


                            @error('pelapor_contact')
                                <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                            @enderror



                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700">{{ __('pengaduan.email') }}
                                <span class="text-rose-500">*</span></label>
                            </label>
                            <input type="text" name="email" value="{{ old('email') }}"
                                class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300"
                                placeholder="{{ __('pengaduan.email_name') }}">
                            @error('email')
                                <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            // field nama yang dipakai (lokalisasi)
                            $locale = app()->getLocale();
                            $namaField = $locale === 'id' ? 'nama' : 'nama_en';

                            // cari record kategori yang isinya 'Lainnya' (case-insensitive)
                            $lainnyaModel = $kategoris->first(function ($it) use ($namaField) {
                                return strcasecmp(trim($it->{$namaField} ?? ''), 'Lainnya') === 0 ||
                                    strcasecmp(trim($it->{$namaField} ?? ''), 'Lainnya...') === 0 ||
                                    strcasecmp(trim($it->{$namaField} ?? ''), 'Others') === 0;
                            });

                            // jika ketemu ambil ID-nya, kalau tidak -> null
                            $lainnyaId = $lainnyaModel?->id;
                        @endphp

                        <div x-data="{ isOther: {{ old('kategori_id') == $lainnyaId ? 'true' : 'false' }} }">
                            <label class="block text-sm font-medium text-slate-700">{{ __('pengaduan.category') }}
                                <span class="text-rose-500">*</span></label>

                            <select name="kategori_id"
                                x-on:change="isOther = ($event.target.value == '{{ $lainnyaId ?? '___no_lainnya_id___' }}')"
                                class="mt-1 w-full border rounded-lg px-3 pr-9 py-2 text-sm focus:ring-2 focus:ring-indigo-300">
                                <option value="">{{ __('pengaduan.select') }}</option>

                                @foreach ($kategoris as $k)
                                    <option value="{{ $k->id }}" @selected(old('kategori_id') == $k->id)>
                                        {{ $k->{$namaField} }}
                                    </option>
                                @endforeach

                                {{-- jika tidak ada row 'Lainnya' di DB, kita tetap bisa beri option 'Lainnya' (value special string) tapi disarankan menambahkan row di DB. --}}
                                @unless ($lainnyaId)
                                    <option value="__lainnya_manual__" @selected(old('kategori_id') == '__lainnya_manual__')>Lainnya...</option>
                                @endunless
                            </select>

                            {{-- Input muncul hanya jika pilih opsi Lainnya dari table (atau opsi manual jika tidak ada) --}}
                            <div x-show="isOther" x-cloak class="mt-2">
                                <input type="text" name="kategori_lainnya" value="{{ old('kategori_lainnya') }}"
                                    placeholder="Tulis kategori lainnya..."
                                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500">

                                @error('kategori_lainnya')
                                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @error('kategori_id')
                                <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>



                        <div>
                            <label class="block text-sm font-medium text-slate-700">{{ __('pengaduan.service') }}
                                <span class="text-rose-500">*</span></label>
                            <select name="jenis_layanan_id"
                                class="mt-1 w-full border rounded-lg px-3 pr-9 py-2 text-sm focus:ring-2 focus:ring-indigo-300">
                                <option value="">{{ __('pengaduan.select') }}</option>
                                @foreach ($layanans as $l)
                                    <option value="{{ $l->id }}" @selected(old('jenis_layanan_id') == $l->id)>
                                        {{ $l->$namaField }}</option>
                                @endforeach
                            </select>
                            @error('jenis_layanan_id')
                                <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700">{{ __('pengaduan.subject') }} <span
                                class="text-rose-500">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                            class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300"
                            placeholder="{{ __('pengaduan.ringkas') }}">
                        @error('judul')
                            <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700">{{ __('pengaduan.description') }}
                            <span class="text-rose-500">*</span></label>
                        <textarea name="deskripsi" rows="6"
                            class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">
                            {{ __('pengaduan.attach_evidence') }}
                            {{-- <span class="text-slate-500 text-xs">(photo/pdf)</span> --}}
                        </label>

                        <div class="mt-2 flex items-center gap-3">
                            <label for="bukti_masyarakat"
                                class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium  text-white bg-linear-to-r from-indigo-600 to-sky-500  hover:from-indigo-700 hover:to-sky-600 focus:outline-none focus:ring-2 focus:ring-indigo-400/40 shadow-sm transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                {{ __('pengaduan.choose_file') }}
                            </label>

                            <input id="bukti_masyarakat" type="file" name="bukti_masyarakat[]"
                                accept="image/jpeg,image/jpg,image/png" multiple class="hidden" />
                            {{-- <input id="bukti_masyarakat" type="file" name="bukti_masyarakat[]"
                                accept="image/*,application/pdf" multiple class="hidden" /> --}}

                            <p id="file-info" class="text-sm text-slate-500">{{ __('pengaduan.no_file_chosen') }}</p>
                        </div>

                        @error('bukti_masyarakat')
                            <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>

            </div>
            {{-- Script preview nama file --}}
            <script>
                document.getElementById('bukti_masyarakat').addEventListener('change', function(e) {
                    const info = document.getElementById('file-info');
                    if (this.files.length === 0) {
                        info.textContent = '{{ __('pengaduan.no_file_chosen') }}';
                    } else {
                        const names = Array.from(this.files).map(f => f.name).join(', ');
                        info.textContent = names;
                    }
                });
            </script>


            <!-- Garis pembatas -->
            <hr class="mt-6 mb-4 border-t border-slate-200">

            <!-- Tombol aksi -->
            <div class="flex flex-col sm:flex-row justify-end items-stretch sm:items-center gap-2 sm:gap-3 w-full">
                <!-- Tombol Kirim -->
                <button type="submit"
                    class="cursor-pointer inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-300/60 transition w-full sm:w-auto">
                    <!-- Ikon kirim -->
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-4 w-4 bi bi-send"
                        viewBox="0 0 16 16">
                        <path
                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z" />
                    </svg>
                    <span>{{ __('pengaduan.submit') }}</span>
                </button>

                <!-- Tombol Reset -->
                <button type="reset"
                    class="cursor-pointer inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200 focus:outline-none focus:ring-2 focus:ring-slate-200 transition w-full sm:w-auto">
                    <!-- Ikon refresh -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                        <path
                            d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                    </svg>
                    <span>{{ __('pengaduan.reset') }}</span>
                </button>
            </div>

            </form>

        </div>
        </div>
    </main>


    {{-- Alert global (Swal) --}}
    @include('components.alert')
    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('bukti')
            const preview = document.getElementById('preview')
            if (!input) return

            input.addEventListener('change', () => {
                preview.innerHTML = ''
                Array.from(input.files).forEach(file => {
                    const wrapper = document.createElement('div')
                    wrapper.className =
                        'relative overflow-hidden rounded border border-slate-200 bg-white/70 backdrop-blur-sm'

                    if (file.type.startsWith('image/')) {
                        const url = URL.createObjectURL(file)
                        const img = document.createElement('img')
                        img.src = url
                        img.className = 'w-full h-28 object-cover'
                        wrapper.appendChild(img)
                    } else {
                        const el = document.createElement('div')
                        el.className = 'p-3 text-xs text-slate-600 text-center'
                        el.textContent = file.name
                        wrapper.appendChild(el)
                    }

                    preview.appendChild(wrapper)
                })
            })
        })
    </script> --}}
</body>

</html>
