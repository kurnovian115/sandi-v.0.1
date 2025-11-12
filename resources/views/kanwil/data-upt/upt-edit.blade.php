@php
    // helper singkat untuk isi value: ambil old() kalau ada, else dari $unit
    $v = fn($key, $default = '') => old($key, $unit->$key ?? $default);
@endphp

<x-layout :title="$title">
    <div class="max-w-4xl mx-auto px-4 lg:px-0">
        {{-- @include('components.alert') --}}

        <form action="{{ route('kanwil.upt.update', $unit->id) }}" method="POST"
            class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            @csrf
            @method('PUT')

            {{-- HEADER (nyatu dgn form) --}}
            <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-lg font-semibold">Edit UPT</h1>
                        <p class="text-xs text-indigo-100/90">{{ $unit->name }}</p>
                    </div>
                </div>
            </div>

            {{-- BODY --}}
            <div class="px-6 py-6 grid grid-cols-1 gap-5">
                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-[13px] font-medium text-slate-700 mb-1">
                        Nama UPT <span class="text-rose-600">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ $v('name') }}"
                        class="w-full rounded-lg text-sm
                        border {{ $errors->has('name') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-indigo-500 focus:ring-indigo-500' }} "
                        autofocus>
                    <p class="mt-1 text-xs text-slate-500">Gunakan nama resmi sesuai SK.</p>
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div>
                    <label for="address" class="block text-[13px] font-medium text-slate-700 mb-1">Alamat</label>
                    <textarea name="address" id="address" rows="3"
                        class="w-full rounded-lg text-sm
                   border {{ $errors->has('address') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-indigo-500 focus:ring-indigo-500' }} resize-y"
                        maxlength="500">{{ $v('address') }}</textarea>
                    @error('address')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status (segmented) --}}
                <div>
                    <label class="block text-[13px] font-medium text-slate-700 mb-2">Status</label>
                    <div class="inline-flex rounded-lg p-0.5 bg-slate-100 border border-slate-200">
                        <input type="radio" id="st-aktif" name="is_active" value="1" class="sr-only peer/aktif"
                            {{ (int) $v('is_active', 1) === 1 ? 'checked' : '' }}>
                        <label for="st-aktif"
                            class="px-4 py-2 text-sm rounded-md cursor-pointer
                     peer-checked/aktif:bg-emerald-100 peer-checked/aktif:text-emerald-800">
                            Aktif
                        </label>

                        <input type="radio" id="st-non" name="is_active" value="0" class="sr-only peer/non"
                            {{ (int) $v('is_active', 1) === 0 ? 'checked' : '' }}>
                        <label for="st-non"
                            class="px-4 py-2 text-sm rounded-md cursor-pointer
                     peer-checked/non:bg-rose-100 peer-checked/non:text-rose-800">
                            Nonaktif
                        </label>
                    </div>
                    @error('is_active')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">
                <a href="{{ route('kanwil.upt.index', $unit->id) }}"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm border border-slate-300 text-slate-700 hover:bg-white transition">
                    <i class="bi bi-arrow-left"></i> Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm
                       bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500
                       cursor-pointer transition-all duration-150 active:scale-[0.98]">
                    <i class="bi bi-check-circle"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-layout>
