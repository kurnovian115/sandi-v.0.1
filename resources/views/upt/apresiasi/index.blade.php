{{-- resources/views/positive_reviews/index.blade.php --}}
<x-layout :title="$title ?? 'Ulasan Positif'">
    <div class="max-w-6xl mx-auto px-4 lg:px-0 py-6">

        {{-- Header --}}
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white mb-6">
            <div class="px-6 py-5 bg-linear-to-r from-indigo-600 to-sky-500 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-lg font-semibold">Daftar Ulasan Positif</h1>
                        <p class="text-xs text-indigo-100/90 mt-1">
                            Menampilkan ulasan yang dikumpulkan per UPT — gunakan filter untuk mempersempit.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Filter bar (rapi, horizontal-first, wrap when needed) --}}
            <div class="px-6 py-4 border-t border-slate-100 bg-white">
                <form method="GET" action="{{ route('upt.apresiasi.index') }}">
                    <div class="grid gap-4"
                        style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); align-items: end;">
                        {{-- Search + Buttons (this cell stretches) --}}
                        <div style="display:flex; gap:0.75rem; align-items:flex-end;">
                            <div style="flex:1;">
                                <label class="block text-xs text-slate-600 mb-1">Cari</label>
                                <input type="search" name="q" value="{{ request('q') }}"
                                    placeholder="nama / ulasan"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm h-11 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400" />
                            </div>


                        </div>
                        {{-- UPT --}}
                        @php
                            $role = optional(Auth::user()->role)->name;
                        @endphp

                        @if ($role !== 'admin_upt')
                            <div>
                                <label class="block text-xs text-slate-600 mb-1">UPT</label>
                                <select name="upt_id"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm h-11 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                                    <option value="">— Semua UPT —</option>
                                    @foreach ($upts ?? [] as $u)
                                        <option value="{{ $u->id }}" @selected(request('upt_id') == $u->id)>
                                            {{ $u->name ?? ($u->nama ?? '-') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif


                        {{-- Layanan --}}
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Layanan</label>
                            <select name="layanan_id"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm h-11 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                                <option value="">— Semua Layanan —</option>
                                @php $locale = app()->getLocale(); @endphp
                                @foreach ($layanans ?? [] as $l)
                                    @php
                                        $label =
                                            $l->nama ??
                                            ($locale === 'en'
                                                ? $l->nama_en ?? ($l->name ?? '-')
                                                : $l->nama ?? ($l->name ?? '-'));
                                    @endphp
                                    <option value="{{ $l->id }}" @selected(request('layanan_id') == $l->id)>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Rating --}}
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Rating</label>
                            <select name="rating"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm h-11 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                                <option value="">— Semua —</option>
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" @selected((string) request('rating') === (string) $i)>{{ $i }}
                                        ★
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div
                            style="display:flex; flex-direction:row; gap:0.5rem; align-items:center; justify-content:flex-start;">

                            <button type="submit"
                                class="inline-flex items-center rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 text-sm h-11">
                                Filter
                            </button>

                            <button type="button" onclick="window.location='{{ route('upt.apresiasi.index') }}'"
                                class="inline-flex items-center rounded-lg border border-slate-200 bg-white text-slate-700 px-4 py-2 text-sm h-11 hover:bg-slate-50">
                                Reset
                            </button>

                        </div>

                    </div>

                    {{-- total --}}
                    <div class="mt-3 text-xs text-slate-500">Total: <strong
                            class="text-slate-700">{{ $reviews->total() ?? 0 }}</strong></div>
                </form>
            </div>

        </div>

        {{-- Table --}}
        <div class="rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
            <div class="px-6 py-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th class="px-3 py-2 w-12">#</th>
                            <th class="px-3 py-2">UPT / Layanan</th>
                            <th class="px-3 py-2">Pelapor & Ulasan</th>
                            <th class="px-3 py-2 hidden lg:table-cell">Contact / Email</th>
                            <th class="px-3 py-2 w-40">Rating</th>
                            <th class="px-3 py-2 hidden lg:table-cell w-40">Tanggal</th>
                            <th class="px-3 py-2 w-28">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($reviews as $idx => $r)
                            @php
                                $uptLabel = null;
                                if (!empty($r->upt_id)) {
                                    $uptLabel = optional($upts->firstWhere('id', $r->upt_id))->name ?? $r->upt_id;
                                } elseif (!empty($r->meta['upt_id'] ?? null)) {
                                    $uptLabel =
                                        optional($upts->firstWhere('id', $r->meta['upt_id']))->name ??
                                        $r->meta['upt_id'];
                                }

                                $layananLabel = null;
                                if (!empty($r->jenis_layanan_id)) {
                                    $layananLabel =
                                        optional($layanans->firstWhere('id', $r->jenis_layanan_id))->nama ??
                                        (optional($layanans->firstWhere('id', $r->jenis_layanan_id))->name ??
                                            $r->jenis_layanan_id);
                                } elseif (!empty($r->meta['jenis_layanan_id'] ?? null)) {
                                    $layananLabel =
                                        optional($layanans->firstWhere('id', $r->meta['jenis_layanan_id']))->nama ??
                                        (optional($layanans->firstWhere('id', $r->meta['jenis_layanan_id']))->name ??
                                            $r->meta['jenis_layanan_id']);
                                }

                                $rating = (int) $r->rating;
                            @endphp

                            <tr>
                                <td class="px-3 py-3 text-slate-500">{{ $reviews->firstItem() + $idx }}</td>

                                <td class="px-3 py-3">
                                    <div class="text-sm font-medium">{{ $uptLabel ?? '-' }}</div>
                                    <div class="text-xs text-slate-500 mt-1">{{ $layananLabel ?? '-' }}</div>
                                </td>

                                <td class="px-3 py-3">
                                    <div class="text-sm font-medium">{{ $r->pelapor_nama ?: '-' }}</div>
                                    <div class="text-xs text-slate-500 mt-1 line-clamp-2">
                                        {{ $r->note ? \Illuminate\Support\Str::limit($r->note, 140) : '-' }}</div>
                                </td>

                                <td class="px-3 py-3 hidden lg:table-cell">
                                    <div class="text-sm">{{ $r->pelapor_contact ?: '-' }}</div>
                                    <div class="text-xs text-slate-500 mt-1">{{ $r->email ?: '-' }}</div>
                                </td>

                                <td class="px-3 py-3">
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @php
                                                $filled = $i <= $rating;
                                                // choose color intensity depending on rating
                                                $colorClass =
                                                    $rating === 5
                                                        ? 'text-yellow-400'
                                                        : ($rating === 4
                                                            ? 'text-yellow-300'
                                                            : ($rating === 3
                                                                ? 'text-yellow-200'
                                                                : 'text-slate-300'));
                                            @endphp
                                            <span
                                                class="{{ $filled ? $colorClass : 'text-slate-300' }} mr-1 text-lg transition-transform duration-150">
                                                {{ $filled ? '★' : '☆' }}
                                            </span>
                                        @endfor
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">{{ $r->rating }} / 5</div>
                                </td>

                                <td class="px-3 py-3 hidden lg:table-cell text-slate-500">
                                    {{ optional($r->created_at)->format('Y-m-d H:i') ?? '-' }}
                                </td>

                                <td class="px-3 py-3">
                                    <div class="flex gap-2">
                                        <button type="button"
                                            class="px-3 py-1.5 rounded-md bg-indigo-600 text-white text-xs view-detail-btn"
                                            data-note="{{ e($r->note) }}" data-name="{{ e($r->pelapor_nama) }}"
                                            data-contact="{{ e($r->pelapor_contact) }}"
                                            data-email="{{ e($r->email) }}" data-upt="{{ e($uptLabel) }}"
                                            data-layanan="{{ e($layananLabel) }}" data-rating="{{ $r->rating }}">
                                            Lihat
                                        </button>

                                        @can('delete', $r)
                                            <form method="POST" action="{{ route('positive_review.destroy', $r->id) }}"
                                                onsubmit="return confirm('Hapus ulasan ini?')">
                                                @csrf @method('DELETE')
                                                <button
                                                    class="px-3 py-1.5 rounded-md bg-rose-600 text-white text-xs">Hapus</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">Belum ada ulasan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-white flex items-center justify-between">
                <div class="text-xs text-slate-500">
                    Menampilkan {{ $reviews->firstItem() ?? 0 }} – {{ $reviews->lastItem() ?? 0 }} dari
                    {{ $reviews->total() ?? 0 }}
                </div>

                <div>
                    {{ $reviews->withQueryString()->links() }}
                </div>
            </div>
        </div>

        {{-- Modal detail (boxed + header biru) --}}
        <div id="detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40"></div>
            <div
                class="relative max-w-2xl w-full bg-white rounded-lg shadow-lg border border-slate-200 overflow-hidden">
                <header
                    class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-sky-500 text-white flex items-start justify-between gap-4">
                    <div>
                        <h3 id="modal-name" class="text-lg font-semibold">Nama</h3>
                        <p id="modal-upt" class="text-sm text-indigo-100 mt-1">UPT • Layanan</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button id="modal-close"
                            class="px-3 py-1 rounded-md bg-white/10 hover:bg-white/20 text-white">Tutup</button>
                    </div>
                </header>

                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <div class="text-xs text-slate-500">Kontak</div>
                            <div id="modal-contact" class="text-sm font-medium mt-1"></div>
                            <div id="modal-email" class="text-sm text-slate-500 mt-1"></div>
                        </div>

                        <div>
                            <div class="text-xs text-slate-500">Rating</div>
                            <div id="modal-rating" class="text-sm font-medium mt-2 flex items-center gap-2"></div>
                        </div>

                        <div>
                            <div class="text-xs text-slate-500">Ulasan</div>
                            <div id="modal-note" class="text-sm mt-2 whitespace-pre-line"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('detail-modal');
            const btns = document.querySelectorAll('.view-detail-btn');
            const close = document.getElementById('modal-close');

            function openModal(data) {
                document.getElementById('modal-name').textContent = data.name || '-';
                document.getElementById('modal-upt').textContent = (data.upt ? (data.upt + (data.layanan ? ' • ' +
                    data.layanan : '')) : (data.layanan || '-'));
                document.getElementById('modal-contact').textContent = data.contact || '-';
                document.getElementById('modal-email').textContent = data.email || '-';

                // rating stars with color intensity
                let rating = parseInt(data.rating || 0, 10);
                let container = document.getElementById('modal-rating');
                container.innerHTML = '';
                for (let i = 1; i <= 5; i++) {
                    const span = document.createElement('span');
                    span.style.marginRight = '6px';
                    span.style.fontSize = '20px';
                    span.style.transition = 'transform .12s ease';
                    span.textContent = i <= rating ? '★' : '☆';

                    if (i <= rating) {
                        if (rating === 5) {
                            span.className = 'text-yellow-400';
                            span.style.filter = 'drop-shadow(0 10px 24px rgba(250,204,21,0.12))';
                            span.style.transform = 'translateY(-2px) scale(1.06)';
                        } else if (rating === 4) {
                            span.className = 'text-yellow-300';
                        } else if (rating === 3) {
                            span.className = 'text-yellow-200';
                        } else {
                            span.className = 'text-yellow-100';
                        }
                    } else {
                        span.className = 'text-slate-300';
                    }
                    container.appendChild(span);
                }
                const metaText = document.createElement('div');
                metaText.className = 'text-xs text-slate-500';
                metaText.style.marginLeft = '6px';
                metaText.textContent = `${rating} / 5`;
                container.appendChild(metaText);

                document.getElementById('modal-note').textContent = data.note || '-';

                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            btns.forEach(b => {
                b.addEventListener('click', () => {
                    const data = {
                        name: b.dataset.name,
                        upt: b.dataset.upt,
                        layanan: b.dataset.layanan,
                        contact: b.dataset.contact,
                        email: b.dataset.email,
                        note: b.dataset.note,
                        rating: b.dataset.rating
                    };
                    openModal(data);
                });
            });

            close.addEventListener('click', closeModal);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeModal();
            });
        });
    </script>

    <style>
        /* more visible star hover + transition in table */
        .text-yellow-400 {
            color: #f59e0b;
        }

        /* nice bright */
        .text-yellow-300 {
            color: #fbbf24;
        }

        .text-yellow-200 {
            color: #fde68a;
        }

        .text-slate-300 {
            color: #cbd5e1;
        }

        /* subtle hover on table rows */
        table tbody tr:hover td {
            background: rgba(15, 23, 42, 0.02);
            transition: background .12s ease;
        }

        /* small responsive adjustments */
        @media (max-width: 768px) {
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        }
    </style>
</x-layout>
