<x-layout :title="$title ?? ($kategori->exists ? 'Edit Kategori' : 'Tambah Kategori')">
    <div class="max-w-3xl mx-auto px-4 lg:px-0">
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            <div
                class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white flex items-center justify-between">
                <div>
                    <h1 class="text-lg font-semibold">{{ $kategori->exists ? 'Edit Kategori' : 'Tambah Kategori' }}</h1>
                    <p class="text-xs text-indigo-100/90">Isikan data kategori pengaduan.</p>
                </div>
                <a href="{{ route('kategori-pengaduan.index') }}"
                    class="px-3 py-2 rounded-lg text-sm bg-slate-200 text-slate-800 hover:bg-slate-300">Kembali</a>
            </div>

            <form method="POST"
                action="{{ $kategori->exists ? route('kategori-pengaduan.update', $kategori->id) : route('kategori-pengaduan.store') }}"
                class="px-6 py-5 space-y-3">
                @csrf
                @if ($kategori->exists)
                    @method('PUT')
                @endif

                <div>
                    <label class="block text-sm font-medium">Nama Kategori <span class="text-rose-600">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm" required>
                    @error('nama')
                        <div class="text-rose-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium">Kode (opsional)</label>
                    <input type="text" name="kode" value="{{ old('kode', $kategori->kode) }}"
                        class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                </div>

                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $kategori->is_active) ? 'checked' : '' }}>
                    <span class="text-sm">Status</span>
                </label>

                <div class="pt-2 flex gap-2">
                    <button
                        class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm">Simpan</button>
                    <a href="{{ route('kategori-pengaduan.index') }}"
                        class="px-4 py-2 rounded-lg bg-slate-200 hover:bg-slate-300 text-sm">Batal</a>
                </div>
            </form>
        </div>

        @include('components.alert')
    </div>
</x-layout>
