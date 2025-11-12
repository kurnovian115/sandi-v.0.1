@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto mt-6">

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            {{-- HEADER --}}
            <div class="px-6 py-4 bg-linear-to-r from-indigo-600 to-sky-500">
                <h1 class="text-white text-lg font-semibold flex items-center gap-2">
                    {{-- plus icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM7.5 4.5a.5.5 0 0 1 1 0V7h2.5a.5.5 0 0 1 0 1H8.5v2.5a.5.5 0 0 1-1 0V8H5a.5.5 0 0 1 0-1h2.5V4.5z" />
                    </svg>
                    Tambah Admin UPT
                </h1>
                <p class="text-indigo-100 text-xs mt-1">Isi data admin UPT secara lengkap dan valid.</p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('kanwil.users.admin-upt.store') }}" class="px-6 py-6 space-y-5">
                @csrf

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Lengkap <span
                            class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm
                      @error('name') border-slate-400 focus:border-slate-500 focus:ring-rose-500
                      @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="Nama lengkap admin" required>
                    @error('name')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIP --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">NIP <span class="text-rose-500">*</span></label>
                    <input type="text" name="nip" value="{{ old('nip') }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm
                      @error('nip') border-slate-400 focus:border-slate-500 focus:ring-rose-500
                      @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="Masukkan NIP" required>
                    @error('nip')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email <span
                            class="text-rose-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm
                      @error('email') border-slate-400 focus:border-slate-500 focus:ring-rose-500
                      @else border-slate-400 focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="nama@email.com" required>
                    @error('email')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- UPT --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Unit Pelaksana Teknis <span
                            class="text-rose-500">*</span></label>
                    <select name="unit_id"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm appearance-none bg-white
                       @error('unit_id') border-rose-400 focus:border-rose-500 focus:ring-rose-500
                       @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        required>
                        <option value="">Pilih UPT</option>
                        @foreach ($units as $u)
                            <option value="{{ $u->id }}" @selected(old('unit_id') == $u->id)>{{ $u->name }}</option>
                        @endforeach
                    </select>
                    @error('unit_id')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Status Akun</label>
                    <div class="mt-1 inline-flex rounded-lg p-0.5 bg-slate-100 border border-slate-200">
                        <input type="radio" id="st-a" name="is_active" value="1" class="sr-only peer/a"
                            {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                        <label for="st-a"
                            class="px-4 py-2 text-sm rounded-md cursor-pointer peer-checked/a:bg-emerald-100 peer-checked/a:text-emerald-800">Aktif</label>

                        <input type="radio" id="st-b" name="is_active" value="0" class="sr-only peer/b"
                            {{ old('is_active') == '0' ? 'checked' : '' }}>
                        <label for="st-b"
                            class="px-4 py-2 text-sm rounded-md cursor-pointer peer-checked/b:bg-rose-100 peer-checked/b:text-rose-800">Nonaktif</label>
                    </div>
                </div>

                {{-- Password --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Kata Sandi <span
                                class="text-rose-500">*</span></label>
                        <input type="password" name="password"
                            class="w-full mt-1 rounded-lg border px-3 py-2 text-sm
                        @error('password') border-rose-400 focus:border-rose-500 focus:ring-rose-500
                        @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                            placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Konfirmasi Kata Sandi <span
                                class="text-rose-500">*</span></label>
                        <input type="password" name="password_confirmation"
                            class="w-full mt-1 rounded-lg border px-3 py-2 text-sm border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ulangi kata sandi" required>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-200">
                    <a href="{{ route('kanwil.users.admin-upt.index') }}"
                        class="px-4 py-2 rounded-lg text-slate-700 border border-slate-300 hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 rounded-lg text-white font-medium
                       bg-indigo-600 hover:bg-indigo-700 transition focus:ring-2 focus:ring-indigo-400">
                        {{-- save icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M2 1a1 1 0 0 0-1 1v12l3-2 3 2 3-2 3 2V4.5a1 1 0 0 0-.293-.707l-2.5-2.5A1 1 0 0 0 9.5 1H2z" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SweetAlert (opsional, cocok dengan pola auto_redirect yang kamu pakai) --}}
    @if (session('success') && session('auto_redirect'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    showConfirmButton: false,
                    timer: 1800,
                    timerProgressBar: true,
                }).then(() => {
                    window.location.href = @json(session('auto_redirect'));
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonText: 'Tutup'
                });
            });
        </script>
    @endif
@endsection
