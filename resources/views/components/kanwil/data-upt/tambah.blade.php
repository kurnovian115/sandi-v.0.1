  <form action="{{ route('kanwil.upt.store') }}" method="POST"
      class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
      @csrf

      {{-- CARD HEADER (nyatu dengan form) --}}
      <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
          <div class="flex items-center justify-between">
              <div>
                  <h1 class="text-lg font-semibold">Tambah UPT Baru</h1>
                  <p class="text-xs text-indigo-100/90">Isi informasi Unit Pelaksana Teknis baru di lingkungan
                      Kantor Wilayah Direktorat Jenderal Imigrasi Jawa Barat</p>
              </div>
              {{-- <a href="{{ route('kanwil.upt.index') }}"
                        class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm bg-white/15 hover:bg-white/25 transition">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a> --}}
          </div>
      </div>

      {{-- CARD BODY --}}
      <div class="px-6 py-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

              {{-- Nama UPT (full) --}}
              <div class="md:col-span-2">
                  <label for="name" class="block text-[13px] font-medium text-slate-700 mb-1">
                      Nama UPT <span class="text-rose-600">*</span>
                  </label>
                  <input type="text" name="name" id="name" value="{{ old('name') }}"
                      class="w-full rounded-lg text-sm border {{ $errors->has('name') ? 'border-rose-300 focus:border-rose-500 focus:ring-rose-500' : 'border-slate-300 focus:border-indigo-500 focus:ring-indigo-500' }}"
                      placeholder="Kantor Imigrasi Kelas I TPI Bandung" autofocus>
                  <p class="mt-1 text-xs text-slate-500">Gunakan nama resmi sesuai SK.</p>
                  @error('name')
                      <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                  @enderror
              </div>

              {{-- Alamat (full) --}}
              <div class="md:col-span-2">
                  <label for="address" class="block text-[13px] font-medium text-slate-700 mb-1">Alamat</label>
                  <textarea name="address" id="address" rows="3"
                      class="w-full rounded-lg text-sm border border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 resize-y"
                      placeholder="Jl. Surapati No.82, Bandung, Jawa Barat">{{ old('address') }}</textarea>
                  @error('address')
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

          </div>
      </div>

      {{-- CARD FOOTER --}}
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-3">
          <a href="{{ route('kanwil.upt.index') }}"
              class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm border border-slate-300 text-slate-700 hover:bg-white">
              <i class="bi bi-arrow-left"></i> Batal
          </a>
          <button type="submit"
              class="cursor-pointer inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500">
              <i class="bi bi-check-circle"></i> Simpan
          </button>
      </div>
  </form>
