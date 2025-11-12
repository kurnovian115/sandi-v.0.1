<x-layout :title="$title ?? 'Tambah Pengaduan (Eksternal)'">
    <div class="max-w-4xl mx-auto px-4 lg:px-0">
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h1 class="text-lg font-semibold">Tambah Pengaduan — Sumber Eksternal</h1>
                        <p class="text-xs text-indigo-100/90">Input pengaduan dari media sosial, Google Review, email,
                            telepon, atau sumber lain.</p>
                    </div>
                    <a href="{{ route('pengaduan.index') }}"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm bg-white/20 hover:bg-white/30">
                        <i class="bi bi-arrow-left"></i>Kembali
                    </a>
                </div>
            </div>

            <form action="{{ route('pengaduan.eksternal.store') }}" method="POST" enctype="multipart/form-data"
                class="px-6 py-6 space-y-6" x-data="{ src: '{{ old('asal_pengaduan') }}', kat: '{{ old('kategori_id') ? 'list' : (old('kategori_lainnya') ? 'other' : '') }}' }">
                @csrf

                {{-- Row 0: UPT terkunci sesuai user login --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">UPT</label>
                        <input type="text" value="{{ $userUnit?->name ?? '—' }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-slate-50" disabled>
                        <input type="hidden" name="unit_id" value="{{ $userUnit?->id }}">
                    </div>
                </div>

                {{-- Row 1: Layanan & Kategori (dengan opsi Lainnya) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Jenis Layanan<span
                                class="text-rose-600">*</span></label>
                        <select name="jenis_layanan_id"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                            <option value="">Pilih Layanan</option>
                            @foreach ($jenisLayanans as $jl)
                                <option value="{{ $jl->id }}" @selected(old('jenis_layanan_id') == $jl->id)>{{ $jl->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_layanan_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs text-slate-600 mb-1">Kategori Pengaduan<span
                                class="text-rose-600">*</span></label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                            <div class="md:col-span-2">
                                <select x-model="kat" name="kategori_id"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $k)
                                        <option value="{{ $k->id }}" @selected(old('kategori_id') == $k->id)>
                                            {{ $k->nama }}</option>
                                    @endforeach
                                    {{-- <option value="other" @selected(!old('kategori_id') && old('kategori_lainnya'))>Lainnya</option> --}}
                                </select>
                                @error('kategori_id')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div x-show="kat==='other'" x-cloak>
                                <input type="text" name="kategori_lainnya" value="{{ old('kategori_lainnya') }}"
                                    placeholder="Tulis kategori lainnya..."
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('kategori_lainnya')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Pilih salah satu dari daftar, atau pilih</p>
                    </div>
                </div>

                {{-- Row 2: Sumber eksternal --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Sumber / Asal Pengaduan<span
                                class="text-rose-600">*</span></label>
                        <select x-model="src" name="asal_pengaduan"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                            <option value="">Pilih sumber</option>
                            <option value="Instagram" @selected(old('asal_pengaduan') === 'Instagram')>Instagram</option>
                            <option value="Facebook" @selected(old('asal_pengaduan') === 'Facebook')>Facebook</option>
                            <option value="X/Twitter" @selected(old('asal_pengaduan') === 'X/Twitter')>X / Twitter</option>
                            <option value="Google Review" @selected(old('asal_pengaduan') === 'Google Review')>Google Review</option>
                            <option value="TikTok" @selected(old('asal_pengaduan') === 'TikTok')>TikTok</option>
                            <option value="Email" @selected(old('asal_pengaduan') === 'Email')>Email</option>
                            <option value="Telepon" @selected(old('asal_pengaduan') === 'Telepon')>Telepon</option>
                            <option value="Lainnya" @selected(old('asal_pengaduan') === 'Lainnya')>Lainnya</option>
                        </select>
                        @error('asal_pengaduan')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                        <div x-show="src==='Lainnya'" x-cloak class="mt-2">
                            <input type="text" name="asal_pengaduan_lainnya"
                                value="{{ old('asal_pengaduan_lainnya') }}" placeholder="Tulis sumber lainnya..."
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('asal_pengaduan_lainnya')
                                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">URL / Link sumber</label>
                        <input type="url" name="sumber_url" value="{{ old('sumber_url') }}"
                            placeholder="https://..."
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('sumber_url')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Tanggal posting/kejadian</label>
                        <input type="date" name="tanggal_sumber" value="{{ old('tanggal_sumber') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('tanggal_sumber')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row 3: Judul + Deskripsi --}}
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Judul<span
                                class="text-rose-600">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                        @error('judul')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Deskripsi / Ringkasan Keluhan<span
                                class="text-rose-600">*</span></label>
                        <textarea name="deskripsi" rows="6"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row 4: Identitas pelapor opsional --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Nama Pelapor (opsional)</label>
                        <input type="text" name="pelapor_nama" value="{{ old('pelapor_nama') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Kontak Pelapor (opsional)</label>
                        <input type="text" name="pelapor_contact" value="{{ old('pelapor_contact') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="No. HP / email / akun">
                    </div>
                </div>

                {{-- Row 5: Bukti/Lampiran --}}
                <div>
                    <label class="block text-xs text-slate-600 mb-1">Lampiran Bukti (gambar/dokumen, bisa lebih dari
                        satu)</label>
                    <input type="file" name="bukti_masyarakat[]" multiple
                        class="block w-full text-sm file:mr-3 file:px-3 file:py-2 file:rounded-lg file:border-0 file:bg-slate-200 hover:file:bg-slate-300">
                    <p class="text-xs text-slate-500 mt-1">Maks. 5 MB per file.</p>
                    @error('bukti_masyarakat.*')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('pengaduan.index') }}"
                        class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-800 text-sm">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-1 px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm">
                        Simpan Pengaduan
                    </button>
                </div>
            </form>
        </div>

        @include('components.alert')
    </div>
</x-layout>
