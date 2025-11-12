<x-layout :title="$title ?? 'Edit Admin UPT'">
    <div class="max-w-3xl mx-auto mt-6">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-sky-500">
                <h1 class="text-white text-lg font-semibold flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708z" />
                        <path d="M11.5 6.207 9.793 4.5 3.5 10.793V11h.707L11.5 6.207z" />
                    </svg>
                    Edit Admin UPT
                </h1>
                <p class="text-indigo-100 text-xs mt-1">{{ $user->name }}</p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('kanwil.users.admin-upt.update', $user->id) }}"
                class="px-6 py-6 space-y-5">
                @csrf @method('PUT')

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Lengkap <span
                            class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm @error('name') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        required>
                    @error('name')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIP (opsional) --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip', $user->nip) }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm @error('nip') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="8–18 digit (boleh kosong)">
                    @error('nip')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email (opsional) --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm @error('email') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="nama@email.com (boleh kosong)">
                    @error('email')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Unit --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Unit Pelaksana Teknis <span
                            class="text-rose-500">*</span></label>
                    <select name="unit_id"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm appearance-none bg-white
                        @error('unit_id') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @else border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        required>
                        @foreach ($units as $u)
                            <option value="{{ $u->id }}" @selected(old('unit_id', $user->unit_id) == $u->id)>{{ $u->name }}
                            </option>
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
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <label for="st-a"
                            class="px-4 py-2 text-sm rounded-md cursor-pointer peer-checked/a:bg-emerald-100 peer-checked/a:text-emerald-800">Aktif</label>

                        <input type="radio" id="st-b" name="is_active" value="0" class="sr-only peer/b"
                            {{ !old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <label for="st-b"
                            class="px-4 py-2 text-sm rounded-md cursor-pointer peer-checked/b:bg-rose-100 peer-checked/b:text-rose-800">Nonaktif</label>
                    </div>
                </div>

                {{-- Password (opsional) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Kata Sandi (opsional)</label>
                        <div class="relative">
                            <input type="password" name="password" id="pw"
                                class="w-full mt-1 rounded-lg border px-3 py-2 text-sm border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Minimal 8 karakter">
                            <button type="button" onclick="togglePw('pw')"
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-500">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="pwc"
                                class="w-full mt-1 rounded-lg border px-3 py-2 text-sm border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Ulangi sandi">
                            <button type="button" onclick="togglePw('pwc')"
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-slate-500">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex items-center justify-between gap-2 pt-4 border-t border-slate-200">
                    <div class="flex gap-2">
                        <a href="{{ route('kanwil.users.admin-upt.show', $user->id) }}"
                            class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50">Detail</a>

                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('kanwil.users.admin-upt.index') }}"
                            class="px-4 py-2 rounded-lg text-slate-700 border border-slate-300 hover:bg-slate-50">Batal</a>
                        <button type="submit"
                            class="cursor-pointer inline-flex items-center gap-2 px-5 py-2 rounded-lg text-white font-medium bg-indigo-600 hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M2 1a1 1 0 0 0-1 1v12l3-2 3 2 3-2 3 2V4.5a1 1 0 0 0-.293-.707l-2.5-2.5A1 1 0 0 0 9.5 1H2z" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('components.alert')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const togglePw = id => {
            const el = document.getElementById(id);
            el.type = el.type === 'password' ? 'text' : 'password';
        }

        function confirmNonaktif(name) {
            Swal.fire({
                icon: 'warning',
                title: 'Nonaktifkan akun?',
                html: `Admin <b>${name}</b> akan dinonaktifkan.`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Nonaktifkan',
                confirmButtonColor: '#dc2626'
            }).then(r => {
                if (r.isConfirmed) document.getElementById('nonaktif-form').submit();
            });
        }

        function confirmAktifkan(name) {
            Swal.fire({
                icon: 'question',
                title: 'Aktifkan akun?',
                html: `Admin <b>${name}</b> akan diaktifkan.`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Aktifkan',
                confirmButtonColor: '#059669'
            }).then(r => {
                if (r.isConfirmed) document.getElementById('aktifkan-form').submit();
            });
        }
    </script>
</x-layout>
