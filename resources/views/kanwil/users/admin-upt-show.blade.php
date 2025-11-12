<x-layout :title="$title ?? 'Detail Admin UPT'">
    <div class="max-w-4xl mx-auto mt-6">
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden">

            <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-sky-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-white text-lg font-semibold">Detail Admin UPT</h1>
                        <p class="text-indigo-100 text-xs mt-1">{{ $user->name }}</p>
                    </div>
                    <span
                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs {{ $user->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                        <span
                            class="h-2 w-2 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>

            <div class="px-6 py-6 grid md:grid-cols-2 gap-4">
                <div class="rounded-lg border bg-white p-4">
                    <div class="text-slate-500 text-xs">Nama</div>
                    <div class="font-semibold text-slate-900">{{ $user->name }}</div>
                </div>
                <div class="rounded-lg border bg-white p-4">
                    <div class="text-slate-500 text-xs">NIP</div>
                    <div class="font-semibold text-slate-900">{{ $user->nip ?? '-' }}</div>
                </div>
                <div class="rounded-lg border bg-white p-4">
                    <div class="text-slate-500 text-xs">Email</div>
                    <div class="font-semibold text-slate-900">{{ $user->email ?? '-' }}</div>
                </div>
                <div class="rounded-lg border bg-white p-4">
                    <div class="text-slate-500 text-xs">UPT</div>
                    <div class="font-semibold text-slate-900">{{ $user->unit->name ?? '-' }}</div>
                </div>
                <div class="rounded-lg border bg-white p-4">
                    <div class="text-slate-500 text-xs">Dibuat</div>
                    <div class="font-medium text-slate-800">
                        {{ optional($user->created_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }}</div>
                </div>
                <div class="rounded-lg border bg-white p-4">
                    <div class="text-slate-500 text-xs">Diperbarui</div>
                    <div class="font-medium text-slate-800">
                        {{ optional($user->updated_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }}</div>
                </div>
            </div>

            <div class="px-6 py-4 flex items-center justify-between border-t">
                <div class="flex gap-2">
                    <a href="{{ route('kanwil.users.admin-upt.index') }}"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50">Kembali</a>
                    <a href="{{ route('kanwil.users.admin-upt.edit', $user->id) }}"
                        class="px-4 py-2 rounded-lg border border-amber-300 text-amber-700 hover:bg-amber-50">Edit</a>
                </div>

                <div>
                    @if ($user->is_active)
                        <form action="{{ route('kanwil.users.admin-upt.nonaktif', $user->id) }}" method="POST"
                            id="nonaktif-form">@csrf @method('PUT')
                            <button type="button" onclick="confirmNonaktif('{{ $user->name }}')"
                                class="cursor-pointer px-4 py-2 rounded-lg border border-rose-300 text-rose-700 hover:bg-rose-50">Nonaktifkan</button>
                        </form>
                    @else
                        <form action="{{ route('kanwil.users.admin-upt.aktifkan', $user->id) }}" method="POST"
                            id="aktifkan-form">@csrf @method('PUT')
                            <button type="button" onclick="confirmAktifkan('{{ $user->name }}')"
                                class="cursor-pointer px-4 py-2 rounded-lg border border-emerald-300 text-emerald-700 hover:bg-emerald-50">Aktifkan</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('components.alert')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
