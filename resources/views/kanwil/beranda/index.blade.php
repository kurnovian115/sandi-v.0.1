{{-- resources/views/kanwil/dashboard/index.blade.php --}}
<x-layout :title="$title ?? 'Dashboard Pengaduan'">
    @php
        // Siapkan opsi UPT; fallback dari barLabels bila $upts kosong
        $unitOptions = collect($upts ?? [])
            ->map(fn($u) => ['id' => $u->id, 'nama' => $u->nama ?? $u->name])
            ->values()
            ->all();
        if (empty($unitOptions) && !empty($barLabels ?? [])) {
            $unitOptions = collect($barLabels)->values()->map(fn($n, $i) => ['id' => $i + 1, 'nama' => $n])->all();
        }

        // Siapkan opsi Layanan; fallback dari pieLabels bila $layanan tidak ada
        $layananOptions = collect($layanans ?? ($layanan ?? []))
            ->map(fn($l) => ['id' => $l->id, 'nama' => $l->nama])
            ->values()
            ->all();
        if (empty($layananOptions) && !empty($pieLabels ?? [])) {
            $layananOptions = collect($pieLabels)->values()->map(fn($n, $i) => ['id' => $i + 1, 'nama' => $n])->all();
        }
    @endphp

    <div class="p-4 md:p-6 space-y-6">
        <!-- Header & Filters -->
        <div class="space-y-1">
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight">{{ $title ?? 'Beranda — Admin Kanwil' }}</h1>
            <p class="text-sm text-gray-500">Ringkasan pengaduan seluruh UPT di lingkungan Kanwil.</p>
        </div>

        {{-- Filters (responsif) - menggunakan form GET sederhana --}}
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
            <div class="min-w-0">
                <input type="month" name="start" value="{{ request('start', now()->startOfYear()->format('Y-m')) }}"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            <div class="min-w-0">
                <input type="month" name="end" value="{{ request('end', now()->format('Y-m')) }}"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" />
            </div>

            {{-- UPT --}}
            <div class="min-w-0">
                <select name="unit_id"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua UPT</option>
                    @foreach ($upts ?? $unitOptions as $u)
                        <option value="{{ $u->id }}" @selected(request('unit_id') == $u->id)>{{ $u->nama ?? $u->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Kategori --}}
            <div class="min-w-0">
                <select name="kategori_id"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategori ?? [] as $k)
                        <option value="{{ $k->id }}" @selected(request('kategori_id') == $k->id)>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Layanan (filter tambahan) --}}
            <div class="min-w-0">
                <select name="layanan_id"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Semua Layanan</option>
                    @foreach ($layanans ?? ($layanan ?? $layananOptions) as $l)
                        <option value="{{ $l->id }}" @selected(request('layanan_id') == $l->id)>{{ $l->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2 lg:col-span-1">
                <div class="flex gap-2">
                    <button type="submit"
                        class="w-full h-full px-4 py-2 rounded-2xl bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm">
                        Terapkan
                    </button>

                    <a href="{{ url()->current() }}"
                        class="w-full h-full px-4 py-2 rounded-2xl bg-slate-200 text-slate-800 text-center">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        {{-- KPI Cards (responsif) --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 md:gap-4">

            {{-- Total --}}
            <div class="rounded-2xl p-4 shadow-sm bg-indigo-50 border border-indigo-100">
                <p class="text-xs text-indigo-700">Total Pengaduan</p>
                <p class="mt-1 text-xl md:text-2xl font-semibold text-indigo-900">
                    {{ number_format($stat['total'] ?? 0) }}
                </p>
            </div>

            {{-- Proses --}}
            <div class="rounded-2xl p-4 shadow-sm bg-amber-50 border border-amber-100">
                <p class="text-xs text-amber-700">Dalam Proses</p>
                <p class="mt-1 text-xl md:text-2xl font-semibold text-amber-900">
                    {{ number_format($stat['proses'] ?? 0) }}
                </p>
            </div>

            {{-- Disposisi ke Layanan (CARD BARU) --}}
            <div class="rounded-2xl p-4 shadow-sm bg-sky-50 border border-sky-100">
                <p class="text-xs text-sky-700">Disposisi ke Layanan</p>
                <p class="mt-1 text-xl md:text-2xl font-semibold text-sky-900">
                    {{ number_format($stat['disposisi'] ?? 0) }}
                </p>
            </div>

            {{-- Selesai --}}
            <div class="rounded-2xl p-4 shadow-sm bg-emerald-50 border border-emerald-100">
                <p class="text-xs text-emerald-700">Selesai</p>
                <p class="mt-1 text-xl md:text-2xl font-semibold text-emerald-900">
                    {{ number_format($stat['selesai'] ?? 0) }}
                </p>
            </div>

            {{-- SLA Terlambat --}}
            <div class="rounded-2xl p-4 shadow-sm bg-red-50 border border-red-200">
                <p class="text-xs text-red-700">SLA Terlambat</p>
                <p class="mt-1 text-xl md:text-2xl font-semibold text-red-800">
                    {{ number_format($stat['sla_terlambat'] ?? 0) }}
                </p>
            </div>

        </div>



        <!-- Charts Row 1 -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow-sm p-4 md:p-6 h-[380px] xl:col-span-2">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold">Trend Pengaduan per Bulan per UPT</h3>
                </div>
                <div class="h-80">
                    <canvas id="lineTrend"></canvas>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-4 md:p-6 h-[380px]">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold">Komposisi per Jenis Layanan</h3>
                </div>
                <div class="h-80">
                    <canvas id="pieLayanan"></canvas>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl shadow-sm p-4 md:p-6 h-[420px]">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold">Jumlah Pengaduan per UPT</h3>
                </div>
                <div class="h-[360px]">
                    <canvas id="barUpt"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-4 md:p-6 h-[420px]">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-semibold">Kategori Pengaduan Terbanyak</h3>
                </div>
                <div class="h-[360px]">
                    <canvas id="polarKategori"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabel Terbaru -->
        <div class="bg-white rounded-2xl shadow-sm p-4 md:p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Pengaduan Terbaru</h2>
                <a href="{{ route('pengaduan.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Lihat
                    semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="py-2 pr-3">KODE</th>
                            <th class="py-2 pr-3">JUDUL</th>
                            <th class="py-2 pr-3">UPT</th>
                            <th class="py-2 pr-3">STATUS</th>
                            <th class="py-2">TANGGAL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        {{-- @dd($latest) --}}
                        @forelse(($latest ?? []) as $row)
                            <tr>
                                <td class="py-2 pr-3 font-medium">{{ $row->kode ?? 'PGD-' . $row->id }}</td>
                                <td class="py-2 pr-3 max-w-[28ch] truncate">{{ $row->judul ?? '-' }}</td>
                                <td class="py-2 pr-3">{{ $row->unit_nama ?? ($row->unit->nama ?? '-') }}</td>
                                <td class="py-2 pr-3">
                                    @php
                                        $st = strtolower($row->status ?? '');
                                    @endphp

                                    @php
                                        $colorClass = str_contains($st, 'selesai')
                                            ? 'bg-green-100 text-green-700'
                                            : (str_contains($st, 'disposisi')
                                                ? 'bg-sky-100 text-sky-700'
                                                : 'bg-yellow-100 text-yellow-700');
                                    @endphp

                                    <span class="px-2 py-1 rounded-full text-xs {{ $colorClass }}">
                                        {{ ucfirst($row->status ?? 'Proses') }}
                                    </span>
                                </td>


                                <td class="py-2">{{ optional($row->created_at)->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="py-6 text-center text-gray-400" colspan="5">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
        <div class="mt-4">
            {{ $latest->appends(request()->except('page'))->links() }}
        </div>
    </div>

    {{-- Scripts (Chart.js tetap dipakai) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.addEventListener('load', () => {
            // Data dari controller (pakai fallback aman)
            const labels = @json($trendMonthLabels ?? []);
            const units = @json($trendUnits ?? []);
            const trend = @json($trendDataByUnitMonthly ?? []);

            const barLabels = @json($barLabels ?? []);
            const barData = @json($barData ?? []);

            const pieLabels = @json($pieLabels ?? []);
            const pieData = @json($pieData ?? []);

            const catLabels = @json($catLabels ?? ($kategoriLabels ?? ($kategoriBarLabels ?? [])));
            const catData = @json($catData ?? ($kategoriData ?? ($kategoriBarData ?? [])));

            // LINE: Trend per UPT
            const lineCtx = document.getElementById('lineTrend');
            if (lineCtx) new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels,
                    datasets: (trend || []).map((data, i) => ({
                        label: units[i] || `UPT ${i + 1}`,
                        data,
                        fill: false,
                        tension: 0.3,
                        borderWidth: 2,
                        pointRadius: 2,
                    }))
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // BAR: Jumlah per UPT
            const barCtx = document.getElementById('barUpt');
            if (barCtx) new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: barLabels,
                    datasets: [{
                        label: 'Jumlah Pengaduan',
                        data: barData,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // PIE: Komposisi per Jenis Layanan
            const pieCtx = document.getElementById('pieLayanan');
            if (pieCtx) new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: pieLabels,
                    datasets: [{
                        data: pieData
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // POLAR AREA: Kategori Pengaduan Terbanyak (berbeda dari bar)
            const polarCtx = document.getElementById('polarKategori');
            if (polarCtx) new Chart(polarCtx, {
                type: 'polarArea',
                data: {
                    labels: catLabels,
                    datasets: [{
                        data: catData
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
</x-layout>
