<x-layout :title="$title ?? 'Edit Layanan'">
    <div class="max-w-3xl mx-auto mt-6">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            {{-- HEADER --}}
            <div class="px-6 py-1 bg-linear-to-r from-indigo-600 to-sky-500">
                <h1 class="text-white text-lg font-semibold flex items-center gap-2">
                    {{-- plus icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-pencil-fill" viewBox="0 0 16 16">
                        <path
                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z" />
                    </svg>
                    Edit Layanan
                </h1>
                <p class="text-indigo-100 text-xs mt-1">Perubahan jenis layanan pengaduan.</p>
            </div>

            {{-- FORM --}}

            <form method="POST" action="{{ route('admin-layanan.update', $l->id) }}" class="px-6 py-6 space-y-5">
                @csrf @method('PUT')

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Layanan <span
                            class="text-rose-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $l->nama) }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm
                        @error('nama') border-rose-400 focus:border-rose-500 focus:ring-rose-500
                        @else border-slate-300  focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="Nama Jenis Pengaduan">
                    @error('nama')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Kode Layanan (optional)</label>
                    <input type="text" name="kode" value="{{ old('kode', $l->kode) }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm 
                        @error('kode') border-rose-400 focus:border-rose-500 focus:ring-rose-500
                        @else border-slate-300  focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="Kode layanan">
                    @error('kode')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-[13px] font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="w-full rounded-lg text-sm border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 resize-y"
                        placeholder="Deskripsi Jenis Layanan">{{ old('deskripsi', $l->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status (segmented) --}}
                <div class="md:col-span-2">
                    <label class="block text-[13px] font-medium text-slate-700 mb-2">Status</label>
                    <div class="inline-flex rounded-lg p-0.5 bg-slate-100 border border-slate-200">
                        <input type="radio" id="st-aktif" name="is_active" value="1" class="sr-only peer/aktif"
                            {{ old('is_active', $l->is_active) ? 'checked' : '' }}>
                        <label for="st-aktif"
                            class="px-4 py-2 text-sm rounded-md cursor-pointer peer-checked/aktif:bg-emerald-100 peer-checked/aktif:text-emerald-800">
                            Aktif
                        </label>

                        <input type="radio" id="st-non" name="is_active" value="0" class="sr-only peer/non"
                            {{ !old('is_active', $l->is_active) ? 'checked' : '' }}>
                        <label for="st-non"
                            class="px-4 py-2 text-sm rounded-md cursor-pointer peer-checked/non:bg-rose-100 peer-checked/non:text-rose-800">
                            Nonaktif
                        </label>
                    </div>
                    @error('is_active')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-200">
                    <a href="{{ route('jenis-layanan.index') }}"
                        class="px-4 py-2 rounded-lg text-slate-700 border border-slate-300 hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class=" cursor-pointer inline-flex items-center gap-2 px-5 py-2 rounded-lg text-white font-medium bg-indigo-600 hover:bg-indigo-700 transition focus:ring-2 focus:ring-indigo-400">
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


    @include('components.alert')
</x-layout>
