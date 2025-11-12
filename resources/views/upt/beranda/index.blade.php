{{-- resources/views/upt/dashboard.blade.php (responsive tidy) --}}

<x-layout :title="$title ?? 'Dashboard UPT'">
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-0">
        {{-- HEADER --}}
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white mb-6">
            <div class="px-4 sm:px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                    <div>
                        <h1 class="text-lg sm:text-xl font-semibold">Dashboard UPT</h1>
                        <p class="text-xs sm:text-sm text-indigo-100/90">Ringkasan pengaduan pada unit Anda.</p>
                    </div>
                    <a href="{{ route('pengaduan.index') }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-sm bg-white/20 hover:bg-white/30">
                        <i class="bi bi-table"></i>
                        Lihat Semua Pengaduan
                    </a>
                </div>
            </div>

            {{-- FILTER --}}
            <div class="px-4 sm:px-6 py-4 border-b bg-white">
                <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Dari</label>
                        <input type="date" name="from"
                            value="{{ request('from', optional($from)->format('Y-m-d')) }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-600 mb-1">Sampai</label>
                        <input type="date" name="to" value="{{ request('to', optional($to)->format('Y-m-d')) }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex gap-2 items-end sm:col-span-2 lg:col-span-1">
                        <button
                            class="flex-1 sm:flex-none cursor-pointer rounded-lg bg-sky-600 hover:bg-sky-700 text-white px-3 py-2 text-sm">Terapkan</button>
                        <a href="{{ route('upt.beranda.index') }}"
                            class="flex-1 sm:flex-none rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-800 px-3 py-2 text-sm text-center">Reset</a>
                    </div>
                </form>
            </div>

            {{-- STAT CARDS (tanpa SLA terlambat) --}}
            <div class="px-4 sm:px-6 py-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div class="p-4 border rounded-2xl bg-white">
                    <p class="text-xs text-slate-500">Total</p>
                    <p class="text-2xl font-semibold">{{ $total }}</p>
                </div>
                <div class="p-4 border rounded-2xl bg-amber-50 border-amber-200">
                    <p class="text-xs text-amber-700">Menunggu</p>
                    <p class="text-2xl font-semibold text-amber-700">{{ $menunggu }}</p>
                </div>
                <div class="p-4 border rounded-2xl bg-indigo-50 border-indigo-200">
                    <p class="text-xs text-indigo-700">Diproses</p>
                    <p class="text-2xl font-semibold text-indigo-700">{{ $disposisi }}</p>
                </div>
                <div class="p-4 border rounded-2xl bg-emerald-50 border-emerald-200">
                    <p class="text-xs text-emerald-700">Selesai</p>
                    <p class="text-2xl font-semibold text-emerald-700">{{ $selesai }}</p>
                </div>
            </div>

            {{-- CHART: Komposisi Status --}}
            <div class="px-4 sm:px-6 pb-2">
                <div class="rounded-2xl border p-4 bg-white">
                    <p class="text-sm font-medium text-slate-700 mb-3">Komposisi Status Pengaduan</p>
                    <div class="w-full">
                        <canvas id="statusChart" class="w-full" height="120"></canvas>
                    </div>
                </div>
            </div>

            {{-- RECENT TABLE (paginate 7) --}}
            <div class="px-4 sm:px-6 pb-6">
                <div class="rounded-2xl border overflow-hidden bg-white">
                    <div class="px-4 py-3 bg-slate-50 border-b text-sm font-medium text-slate-700">Pengaduan Terbaru
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-[720px] md:min-w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600 border-b">
                                <tr>
                                    <th class="text-left py-3 px-3">Waktu</th>
                                    <th class="text-left py-3 px-3">Tiket</th>
                                    <th class="text-left py-3 px-3">Layanan</th>
                                    <th class="text-left py-3 px-3">Kategori</th>
                                    <th class="text-left py-3 px-3">Judul</th>
                                    <th class="text-left py-3 px-3">Status</th>
                                    <th class="text-right py-3 px-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent as $p)
                                    <tr class="border-b last:border-0">
                                        <td class="py-3 px-3 whitespace-nowrap">
                                            {{ optional($p->created_at)->format('d M Y H:i') }}</td>
                                        <td class="py-3 px-3 font-medium break-words">{{ $p->no_tiket }}</td>
                                        <td class="py-3 px-3">{{ optional($p->jenisLayanan)->nama ?: '—' }}</td>
                                        <td class="py-3 px-3">{{ optional($p->kategori)->nama ?: '—' }}</td>
                                        <td class="py-3 px-3 max-w-[260px]">
                                            <div class="line-clamp-2">{{ $p->judul }}</div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded-full border text-xs {{ $p->status_badge_class }}">{{ $p->status_label }}</span>
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <a href="{{ route('pengaduan.show', $p->id) }}"
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md border border-slate-200 hover:bg-slate-50">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-8 text-center text-slate-500">Belum ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t bg-white">
                        {{ $recent->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ChartJS --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('statusChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($chart['labels']),
                        datasets: [{
                            label: 'Jumlah',
                            data: @json($chart['data']),
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                precision: 0
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        </script>

        @include('components.alert')
    </div>
</x-layout>
