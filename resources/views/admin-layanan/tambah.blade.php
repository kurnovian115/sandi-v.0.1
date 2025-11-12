<x-layout :title="$title ?? 'Tambah Pengguna — Admin Layanan'">
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
                    Tambah Admin Layanan
                </h1>
                <p class="text-indigo-100 text-xs mt-1">Isi data Admin Layanan secara lengkap dan valid.</p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('admin-layanan.store') }}" class="px-6 py-6 space-y-5">
                @csrf



                {{-- UPT --}}
                {{-- <div>
                    <label class="block text-sm font-medium text-slate-700">Unit Pelaksana Teknis <span
                            class="text-rose-500">*</span></label>
                    <select name="unit_id" autofocus
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm appearance-none bg-white @error('unit_id') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror">
                        <option value="">Pilih UPT</option>
                        @foreach ($units as $u)
                            <option value="{{ $u->id }}" @selected(old('unit_id') == $u->id)>{{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('unit_id')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div> --}}

                <div>
                    <label class="block text-sm font-medium text-slate-700">Unit Pelaksana Teknis <span
                            class="text-rose-500">*</span></label>

                    @if (!empty($lockedUnit))
                        {{-- tampilkan nama UPT, disable agar tidak bisa diubah --}}
                        <select disabled
                            class="w-full mt-1 rounded-lg border px-3 py-2 text-sm bg-slate-50 border-slate-300">
                            <option value="{{ $lockedUnit }}">{{ optional($units->first())->name ?? '—' }}</option>
                        </select>
                        {{-- tetap kirim nilai unit_id lewat hidden input --}}
                        <input type="hidden" name="unit_id" value="{{ $lockedUnit }}">
                    @else
                        <select name="unit_id" autofocus
                            class="w-full mt-1 rounded-lg border px-3 py-2 text-sm appearance-none bg-white @error('unit_id') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror">
                            <option value="">Pilih UPT</option>
                            @foreach ($units as $u)
                                <option value="{{ $u->id }}" @selected(old('unit_id') == $u->id)>{{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                    @error('unit_id')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Layanan --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Jenis Layanan</label>
                    <select name="layanan_id" class="w-full border rounded-lg px-3 py-2 text-sm">
                        <option value="">-- Pilih Layanan --</option>
                        @foreach ($layanans as $layanan)
                            <option value="{{ $layanan->id }}" @selected(old('layanan_id', $user->layanan_id ?? '') == $layanan->id)>
                                {{ $layanan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('layanan_id')
                        <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>


                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Lengkap <span
                            class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm @error('name') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @else border-slate-300  focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="Nama lengkap admin">
                    @error('name')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIP --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">NIP <span
                            class="text-rose-500">*</span></label>
                    <input type="text" name="nip" value="{{ old('nip') }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm @error('nip') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="Masukkan NIP" inputmode="numeric" pattern="[0-9]*" maxlength="18"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                    @error('nip')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm  @error('email') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="nama@email.com">
                    @error('email')
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
                    <div x-data="{ show: false }">
                        <x-input-label for="password" :value="__('Kata Sandi')" />

                        <div class="relative">
                            <x-text-input id="password" class="block mt-1 w-full pr-10"
                                x-bind:type="show ? 'text' : 'password'" {{-- <— ini bedanya --}} name="password"
                                autocomplete="new-password" placeholder="Minimal 8 karakter" />

                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.284m3.657-2.43A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.3 5.046M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>


                    <div>
                        <!-- Confirm Password -->
                        <div x-data="{ showConfirm: false }">
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Ulang Kata Sandi')" />

                            <div class="relative">
                                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10"
                                    x-bind:type="showConfirm ? 'text' : 'password'" name="password_confirmation"
                                    autocomplete="new-password" placeholder="Ulangi kata sandi" />

                                <!-- tombol mata -->
                                <button type="button" @click="showConfirm = !showConfirm"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                                    <!-- ikon mata tertutup -->
                                    <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>

                                    <!-- ikon mata dicoret -->
                                    <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.284m3.657-2.43A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.958 9.958 0 01-4.3 5.046M3 3l18 18" />
                                    </svg>
                                </button>
                            </div>

                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-200">
                    <a href="{{ route('admin-layanan.index') }}"
                        class="px-4 py-2 rounded-lg text-slate-700 border border-slate-300 hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class=" cursor-pointer inline-flex items-center gap-2 px-5 py-2 rounded-lg text-white font-medium  bg-indigo-600 hover:bg-indigo-700 transition focus:ring-2 focus:ring-indigo-400">
                        {{-- save icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M2 1a1 1 0 0 0-1 1v12l3-2 3 2 3-2 3 2V4.5a1 1 0 0 0-.293-.707l-2.5-2.5A1 1 0 0 0 9.5 1H2z" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @include('components.alert')
</x-layout>
