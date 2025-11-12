<x-layout :title="$title ?? 'Tambah Jenis Layanan'">
    <div class="max-w-3xl mx-auto mt-6">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            {{-- HEADER --}}
            <div class="px-6 py-1 bg-linear-to-r from-indigo-600 to-sky-500">
                <h1 class="text-white text-lg font-semibold flex items-center gap-2">
                    {{-- plus icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM7.5 4.5a.5.5 0 0 1 1 0V7h2.5a.5.5 0 0 1 0 1H8.5v2.5a.5.5 0 0 1-1 0V8H5a.5.5 0 0 1 0-1h2.5V4.5z" />
                    </svg>
                    Tambah Jenis Layanan
                </h1>
                <p class="text-indigo-100 text-xs mt-1">Isi data jenis layanan pengaduan.</p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="{{ route('jenis-layanan.store') }}" class="px-6 py-6 space-y-5">
                @csrf

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Layanan <span
                            class="text-rose-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm @error('nama') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @else border-slate-300  focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="Nama Jenis Pengaduan">
                    @error('nama')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Kode Layanan (optional)</label>
                    <input type="text" name="kode" value="{{ old('kode') }}"
                        class="w-full mt-1 rounded-lg border px-3 py-2 text-sm @error('kode') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @else border-slate-300  focus:border-indigo-500 focus:ring-indigo-500 @enderror"
                        placeholder="Kode layanan">
                    @error('kode')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-[13px] font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="w-full rounded-lg text-sm border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 resize-y"
                        placeholder="Deskripsi Jenis Layanan">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status (segmented) --}}
                <div class="md:col-span-2">
                    <label class="block text-[13px] font-medium text-slate-700 mb-2">Status</label>
                    <div class="inline-flex rounded-lg p-0.5 bg-slate-100 border border-slate-200">
                        <input type="radio" id="st-aktif" name="is_active" value="1" class="sr-only peer/aktif"
                            {{ old('is_active', 1) == 1 ? 'checked' : '' }}>
                        <label for="st-aktif"
                            class="px-4 py-2 text-sm rounded-md cursor-pointer
                            peer-checked/aktif:bg-emerald-100 peer-checked/aktif:text-emerald-800">
                            Aktif
                        </label>

                        <input type="radio" id="st-non" name="is_active" value="0" class="sr-only peer/non">
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
