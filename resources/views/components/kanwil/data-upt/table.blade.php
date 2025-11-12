 <div class="mt-8 rounded-xl border border-slate-300 bg-white shadow-sm overflow-hidden">
     <div class="overflow-x-auto">
         <table class="min-w-full text-sm border border-slate-200">
             {{-- HEADER --}}
             <thead class="bg-linear-to-r from-indigo-600 to-sky-500 border-indigo-100">
                 <tr class="text-white">
                     <th class="px-4 py-3 text-left text-sm font-bold uppercase border border-slate-200">Nama
                         UPT</th>
                     {{-- <th class="px-4 py-3 text-left  text-sm font-bold uppercase border border-slate-200">Kode
                        </th> --}}
                     {{-- <th class="px-4 py-3 text-left  text-sm font-bold uppercase border border-slate-200">Alamat
                        </th> --}}
                     <th class="px-4 py-3 text-center text-sm font-bold uppercase border border-slate-200">Admin
                         UPT</th>
                     <th class="px-4 py-3 text-center text-sm font-bold uppercase border border-slate-200">Status
                     </th>
                     <th class="px-4 py-3 text-center text-sm font-bold uppercase border border-slate-200">Tanggal
                     </th>
                     <th class="px-4 py-3 text-center text-sm font-bold uppercase border border-slate-200 w-64">
                         Aksi</th>
                 </tr>
             </thead>
             <tbody class="divide-y divide-slate-200">
                 @forelse ($upts as $u)
                     <tr class="odd:bg-white even:bg-slate-50/50 hover:bg-indigo-50/60 transition-colors">
                         {{-- Nama UPT --}}
                         <td class="px-4 py-3 font-medium text-slate-900 border border-slate-200">{{ $u->name }}
                         </td>
                         {{-- Admin UPT (center) --}}
                         <td class="px-4 py-3 text-center border border-slate-200">
                             <span
                                 class="inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-700 px-2 py-0.5 text-xs">
                                 <i class="bi bi-people"></i>{{ $u->admins_count ?? ($u->admins->count() ?? 0) }}
                             </span>
                         </td>

                         {{-- Status (center) --}}
                         <td class="px-4 py-3 text-center border border-slate-200">
                             @if ($u->is_active)
                                 <span
                                     class="inline-flex items-center gap-1 rounded-full bg-emerald-100 text-emerald-700 px-2 py-0.5 text-xs">
                                     <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Aktif
                                 </span>
                             @else
                                 <span
                                     class="inline-flex items-center gap-1 rounded-full bg-rose-100 text-rose-700 px-2 py-0.5 text-xs">
                                     <span class="h-2 w-2 rounded-full bg-rose-500"></span> Nonaktif
                                 </span>
                             @endif
                         </td>

                         {{-- Dibuat (center) --}}
                         <td class="px-4 py-3 text-center text-slate-700 border border-slate-200">
                             {{ $u->created_at?->format('d M Y') }}
                         </td>

                         {{-- Aksi (ikon + teks sejajar, rapi) --}}
                         <td class="px-4 py-3 align-middle border border-slate-200 text-left">
                             <div
                                 class="min-w-[300px] sm:min-w-[340px] md:min-w-[360px]
               inline-flex items-center justify-start gap-2
               flex-wrap lg:flex-nowrap whitespace-nowrap">

                                 @php
                                     $btn =
                                         'inline-flex items-center justify-center gap-1.5 h-8 px-3 rounded-md border text-xs font-medium transition duration-150';
                                     $svg = 'w-3.5 h-3.5';
                                 @endphp

                                 {{-- Detail --}}
                                 <a href="{{ url('/kanwil/upt/' . $u->id) }}"
                                     class="{{ $btn }} border-indigo-200 text-indigo-700 hover:bg-indigo-50">
                                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                         class="{{ $svg }}" fill="currentColor">
                                         <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                         <path
                                             d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                     </svg>
                                     <span>Detail</span>
                                 </a>

                                 {{-- Edit --}}
                                 <a href="{{ url('/kanwil/upt/' . $u->id . '/edit') }}"
                                     class="{{ $btn }} border-amber-200 text-amber-700 hover:bg-amber-50">
                                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                         class="{{ $svg }}" fill="currentColor">
                                         <path
                                             d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708z" />
                                         <path d="M11.5 6.207 9.793 4.5 3.5 10.793V11h.707L11.5 6.207z" />
                                     </svg>
                                     <span>Edit</span>
                                 </a>

                                 @if ($u->is_active)
                                     {{-- Nonaktifkan --}}
                                     <form id="deactivate-form-{{ $u->id }}"
                                         action="{{ route('kanwil.upt.nonaktif', $u->id) }}" method="POST"
                                         class="inline">
                                         @csrf @method('PUT')
                                         <button type="button"
                                             onclick="confirmNonaktif({{ $u->id }}, @js($u->name))"
                                             class="{{ $btn }} border-rose-200 text-rose-700 hover:bg-rose-50">
                                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                 class="{{ $svg }}" fill="currentColor">
                                                 <path
                                                     d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5.5 3a.5.5 0 0 1 0-1H16v1zM1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1z" />
                                             </svg>
                                             <span>Nonaktifkan</span>
                                         </button>
                                     </form>
                                 @else
                                     {{-- Aktifkan --}}
                                     <form id="activate-form-{{ $u->id }}"
                                         action="{{ route('kanwil.upt.aktifkan', $u->id) }}" method="POST"
                                         class="inline">
                                         @csrf @method('PUT')
                                         <button type="button"
                                             onclick="confirmAktifkan({{ $u->id }}, @js($u->name))"
                                             class="{{ $btn }} border-emerald-200 text-emerald-700 hover:bg-emerald-50">
                                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                                                 class="{{ $svg }}" fill="currentColor">
                                                 <path
                                                     d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm3.97-8.03a.75.75 0 0 0-1.06-1.06L7.477 9.354 5.53 7.408a.75.75 0 1 0-1.06 1.06L6.97 10.97l5-5z" />
                                             </svg>
                                             <span>Aktifkan</span>
                                         </button>
                                     </form>
                                 @endif
                             </div>
                         </td>


                     </tr>
                 @empty
                     <tr>
                         <td colspan="7" class="px-4 py-12 text-center text-slate-500 border border-slate-200">
                             <i class="bi bi-inbox"></i> Belum ada data UPT.
                         </td>
                     </tr>
                 @endforelse
             </tbody>
         </table>
     </div>

 </div>
 <div class="mt-4">
     {{ $upts->links() }}
 </div>

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
     function confirmNonaktif(id, name) {
         Swal.fire({
             icon: 'warning',
             title: 'Nonaktifkan UPT?',
             html: `<p class="text-slate-600 text-sm">Anda akan menonaktifkan <b>${name}</b>.</p>`,
             showCancelButton: true,
             confirmButtonText: 'Ya, Nonaktifkan',
             cancelButtonText: 'Batal',
             confirmButtonColor: '#dc2626',
             cancelButtonColor: '#6b7280',
             reverseButtons: true,
         }).then((result) => {
             if (result.isConfirmed) {
                 document.getElementById(`deactivate-form-${id}`).submit();
             }
         });
     }

     function confirmAktifkan(id, name) {
         Swal.fire({
             icon: 'question',
             title: 'Aktifkan kembali?',
             html: `<p class="text-slate-600 text-sm">UPT <b>${name}</b> akan diaktifkan kembali.</p>`,
             showCancelButton: true,
             confirmButtonText: 'Ya, Aktifkan',
             cancelButtonText: 'Batal',
             confirmButtonColor: '#059669',
             cancelButtonColor: '#6b7280',
             reverseButtons: true,
         }).then((result) => {
             if (result.isConfirmed) {
                 document.getElementById(`activate-form-${id}`).submit();
             }
         });
     }
 </script>
