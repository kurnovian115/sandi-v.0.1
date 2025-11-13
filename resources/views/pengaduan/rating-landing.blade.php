<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Sandi Jabar — Nilai & Ulasan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <style>
        .card-section {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 6px 18px rgba(2, 6, 23, 0.04);
        }

        .star-btn {
            transition: transform .12s ease, filter .12s ease, color .12s ease, text-shadow .12s ease;
            transform-origin: center;
            font-size: 48px;
            line-height: 1;
            padding: 6px;
            color: #94a3b8;
            border-radius: 8px;
            background: transparent;
            border: none;
            cursor: pointer;
            user-select: none;
        }

        .star-3d {
            color: #f59e0b;
            text-shadow: 0 2px 0 rgba(0, 0, 0, 0.06), 0 8px 28px rgba(0, 0, 0, 0.10);
            filter: drop-shadow(0 8px 20px rgba(245, 158, 11, 0.08));
            transform: translateY(-4px) rotateX(6deg) scale(1.02);
        }

        .star-btn:hover {
            transform: translateY(-8px) scale(1.06);
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.10));
        }

        .star-btn:active {
            transform: translateY(-2px) scale(1.03);
        }

        .center-x {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .center-col {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .word-btn {
            transition: transform .12s, background-color .12s, color .12s, box-shadow .12s;
            border-radius: 999px;
            padding: .4rem .75rem;
            border: 1px solid rgba(2, 6, 23, 0.06);
            background: white;
            color: #1f2937;
            cursor: pointer;
            user-select: none;
        }

        .word-btn.active {
            background: #3730a3;
            color: white;
            border-color: transparent;
            box-shadow: 0 10px 28px rgba(55, 48, 163, 0.12);
            transform: translateY(-4px) scale(1.02);
        }

        #star-row {
            gap: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width:640px) {
            .star-btn {
                font-size: 40px;
                padding: 4px;
            }

            #star-row {
                gap: 8px;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-b from-slate-50 to-white text-slate-800 antialiased">
    <div class="fixed left-2 bottom-0 pb-4 z-50">
        <a href="{{ url('/') }}" role="button"
            class="inline-flex items-center gap-3 px-4 py-2.5 rounded-full shadow-xl bg-gradient-to-r from-indigo-600 to-sky-500 text-white hover:brightness-110 hover:scale-105 transition-transform">

            <!-- Ikon selalu muncul -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16"
                aria-hidden="true">
                <path d="M8 .5l6 5V15a1 1 0 0 1-1 1h-3v-4H6v4H3a1 1 0 0 1-1-1V5.5l6-5z" />
            </svg>

            <!-- Teks hanya tampil di sm ke atas -->
            <span class="hidden sm:inline font-medium">
                Kembali ke Beranda
            </span>
        </a>
    </div>
    <div class="max-w-3xl mx-auto p-6">
        <div class="rounded-2xl overflow-hidden shadow-xl border border-slate-200 bg-white">
            <header
                class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-sky-500 text-white flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                        <img src="/images/logo.png" alt="logo" class="w-7 h-7 object-contain" />
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold leading-tight">Nilai & Ulasan Pelayanan</h1>
                        <p class="text-sm text-indigo-100/90">Sampaikan penilaian singkat untuk layanan keimigrasian</p>
                    </div>
                </div>
                <a href="{{ url('/') }}"
                    class="text-sm bg-white/10 px-3 py-1 rounded text-white hover:bg-white/20">Beranda</a>
            </header>

            <form id="rating-form" action="{{ route('positive_review.store') }}" method="POST"
                class="px-6 py-6 space-y-6" novalidate>
                @csrf
                <input type="text" name="hp_field" value="" autocomplete="off" tabindex="-1"
                    style="position:absolute; left:-9999px;">

                <!-- Pilih UPT (wajib) -->
                <div class="card-section">
                    <h2 class="text-sm font-semibold text-slate-700 mb-3">Pilih Kantor Imigrasi (UPT) <span
                            class="text-rose-500">*</span></h2>

                    <div>
                        <select required name="upt_id" id="upt_id"
                            class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300">
                            <option value="">— Pilih UPT —</option>
                            @isset($upts)
                                @foreach ($upts as $u)
                                    <option value="{{ $u->id }}" @selected(request('upt_id') == $u->id)>{{ $u->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        <p id="err-upt" class="mt-1 text-xs text-rose-600 hidden">Silakan pilih UPT</p>
                    </div>
                    <h2 class="text-sm mt-5 font-semibold text-slate-700 mb-3">Pilih Layanan <span
                            class="text-rose-500">*</span></h2>
                    <div>
                        <select required name="jenis_layanan_id" id="jenis_layanan_id"
                            class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300">
                            <option value="">— Pilih layanan —</option>
                            @isset($layanans)
                                @foreach ($layanans as $l)
                                    <option value="{{ $l->id }}" @selected(old('jenis_layanan_id', request('jenis_layanan_id')) == $l->id)>
                                        {{ $l->nama ?? ($l->nama_en ?? $l->name) }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <p id="err-layanan" class="mt-1 text-xs text-rose-600 hidden">Silakan pilih layanan <span
                                class="text-rose-500">*</span></p>
                    </div>
                </div>

                <!-- Layanan -->
                {{-- <div class="card-section">
                    <h2 class="text-sm font-semibold text-slate-700 mb-3">Pilih Layanan <span
                            class="text-rose-500">*</span></h2>
                    <div>
                        <select required name="jenis_layanan_id" id="jenis_layanan_id"
                            class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300">
                            <option value="">— Pilih layanan —</option>
                            @isset($layanans)
                                @foreach ($layanans as $l)
                                    <option value="{{ $l->id }}" @selected(old('jenis_layanan_id', request('jenis_layanan_id')) == $l->id)>
                                        {{ $l->nama ?? ($l->nama_en ?? $l->name) }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <p id="err-layanan" class="mt-1 text-xs text-rose-600 hidden">Silakan pilih layanan <span
                                class="text-rose-500">*</span></p>
                    </div>
                </div> --}}

                <!-- Kontak -->
                <div class="card-section">
                    <h2 class="text-sm font-semibold text-slate-700 mb-3">Informasi Kontak <span
                            class="text-rose-500">*</span></h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Nama Lengkap <span
                                    class="text-rose-500">*</span></label>
                            <input required name="pelapor_nama" id="pelapor_nama"
                                value="{{ request('pelapor_nama') ?? old('pelapor_nama') }}"
                                class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300" />
                            <p id="err-name" class="mt-1 text-xs text-rose-600 hidden">Nama wajib diisi</p>
                        </div>

                        <div>
                            <label class="block text-xs text-slate-600 mb-1">No. HP <span
                                    class="text-rose-500">*</span></label>
                            <input required name="pelapor_contact" id="pelapor_contact"
                                value="{{ request('pelapor_contact') ?? old('pelapor_contact') }}" inputmode="numeric"
                                maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300" />
                            <p id="err-contact" class="mt-1 text-xs text-rose-600 hidden">No. HP wajib diisi</p>
                        </div>

                        <div>
                            <label class="block text-xs text-slate-600 mb-1">Email <span
                                    class="text-rose-500">*</span></label>
                            <input required type="email" name="email" id="email"
                                value="{{ request('email') ?? old('email') }}"
                                class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300" />
                            <p id="err-email" class="mt-1 text-xs text-rose-600 hidden">Email tidak valid / wajib diisi
                            </p>
                        </div>
                    </div>
                </div>



                <!-- Nilai -->
                <div class="card-section">
                    <h2 class="text-sm font-semibold text-slate-700 mb-3">Nilai layanan <span
                            class="text-rose-500">*</span></h2>

                    <div class="center-col gap-4">
                        <div class="center-x">
                            <div id="star-row" class="bg-slate-50 p-4 rounded-lg border border-slate-100">
                                <button type="button" class="star-btn" data-value="1"
                                    aria-label="1 bintang">☆</button>
                                <button type="button" class="star-btn" data-value="2"
                                    aria-label="2 bintang">☆</button>
                                <button type="button" class="star-btn" data-value="3"
                                    aria-label="3 bintang">☆</button>
                                <button type="button" class="star-btn" data-value="4"
                                    aria-label="4 bintang">☆</button>
                                <button type="button" class="star-btn" data-value="5"
                                    aria-label="5 bintang">☆</button>
                            </div>
                        </div>

                        <div class="text-sm text-slate-500" id="rating-text">Belum memilih</div>

                        <div class="center-x mt-2">
                            <div class="flex gap-3 flex-wrap justify-center">
                                <button type="button" class="word-btn" data-value="1">Buruk</button>
                                <button type="button" class="word-btn" data-value="2">Kurang</button>
                                <button type="button" class="word-btn" data-value="3">Cukup</button>
                                <button type="button" class="word-btn" data-value="4">Baik</button>
                                <button type="button" class="word-btn" data-value="5">Sangat Baik</button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="rating" id="rating" value="{{ old('rating') ?? '' }}">
                </div>

                <!-- Pengalaman berkesan (ONLY visible when rating > 3) -->
                <div class="card-section" id="experience-section" style="display:none;">
                    <h2 class="text-sm font-semibold text-slate-700 mb-3">Ulasan <span class="text-rose-500">*</span>
                    </h2>
                    <!-- name="note" agar sinkron dengan controller/request -->
                    <textarea name="note" id="note" rows="4"
                        class="mt-1 w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-300"
                        placeholder="Ceritakan pengalaman, kesan, atau detail yang ingin Anda sampaikan..."></textarea>
                    <p id="err-experience" class="mt-1 text-xs text-rose-600 hidden">Mohon jelaskan pengalaman Anda
                        jika diminta.</p>
                </div>

                <!-- actions -->
                <div class="flex justify-between items-center gap-4">
                    <div class="text-sm text-slate-400">Isi semua kolom sebelum melanjutkan.</div>

                    <div class="flex gap-3">
                        {{-- <button type="button" id="to-create-btn"
                        
                            class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg border hover:bg-slate-200 hidden">Lanjut
                            Isi Pengaduan</button> --}}
                        <button type="button" id="to-create-btn"
                            class="px-4 py-2 bg-rose-500 text-white rounded-lg border hover:bg-rose-600 hidden">
                            Lanjut Isi Pengaduan
                        </button>


                        <button type="submit" id="send-review-btn"
                            class="px-4 py-2 bg-emerald-600 text-white rounded-lg shadow hover:bg-emerald-700 disabled:opacity-60"
                            disabled>Kirim Ulasan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- include swal component (you said it's available) --}}
    @include('components.alert')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stars = Array.from(document.querySelectorAll('.star-btn'));
            const words = Array.from(document.querySelectorAll('.word-btn'));
            const ratingInput = document.getElementById('rating');
            const ratingText = document.getElementById('rating-text');
            const sendBtn = document.getElementById('send-review-btn');
            const toCreateBtn = document.getElementById('to-create-btn');
            const form = document.getElementById('rating-form');

            const inputName = document.getElementById('pelapor_nama');
            const inputContact = document.getElementById('pelapor_contact');
            const inputEmail = document.getElementById('email');
            const inputUpt = document.getElementById('upt_id');
            const inputLayanan = document.getElementById('jenis_layanan_id');
            const experienceSection = document.getElementById('experience-section');
            const experienceInput = document.getElementById('note');

            const errName = document.getElementById('err-name');
            const errContact = document.getElementById('err-contact');
            const errEmail = document.getElementById('err-email');
            const errUpt = document.getElementById('err-upt');
            const errLayanan = document.getElementById('err-layanan');
            const errExperience = document.getElementById('err-experience');

            const labelMap = {
                1: 'Buruk',
                2: 'Kurang',
                3: 'Cukup',
                4: 'Baik',
                5: 'Sangat Baik'
            };

            function applyRating(val) {
                val = parseInt(val) || 0;

                // stars visuals
                stars.forEach(s => {
                    const v = parseInt(s.dataset.value);
                    if (v <= val) {
                        s.classList.add('star-3d');
                        s.classList.remove('text-slate-400');
                    } else {
                        s.classList.remove('star-3d');
                        s.classList.add('text-slate-400');
                    }
                });

                // words active
                words.forEach(w => {
                    const v = parseInt(w.dataset.value);
                    if (v === val) w.classList.add('active');
                    else w.classList.remove('active');
                });

                ratingText.textContent = val ? `${labelMap[val]} • ${val} bintang` : 'Belum memilih';

                // experience visible when rating > 3 (i.e. 4 or 5)
                if (val > 3) {
                    experienceSection.style.display = 'block';
                    sendBtn.disabled = false; // allow sending positive review
                    toCreateBtn.classList.add('hidden');
                } else if (val > 0) {
                    experienceSection.style.display = 'none';
                    sendBtn.disabled = true;
                    toCreateBtn.classList.remove('hidden');
                } else {
                    experienceSection.style.display = 'none';
                    sendBtn.disabled = true;
                    toCreateBtn.classList.add('hidden');
                }

                ratingInput.value = val;
            }

            // bind stars & keyboard
            stars.forEach(s => {
                s.addEventListener('click', () => applyRating(s.dataset.value));
                s.tabIndex = 0;
                s.addEventListener('keydown', (e) => {
                    const idx = stars.indexOf(s);
                    if (e.key === 'ArrowRight' && idx < stars.length - 1) stars[idx + 1].focus();
                    if (e.key === 'ArrowLeft' && idx > 0) stars[idx - 1].focus();
                    if (e.key === 'Enter' || e.key === ' ') applyRating(s.dataset.value);
                });
            });
            words.forEach(w => w.addEventListener('click', () => applyRating(w.dataset.value)));

            function isEmailValid(v) {
                return /\S+@\S+\.\S+/.test(v);
            }

            function validateRequired(showErrors = true) {
                let ok = true;
                if (!inputName.value.trim()) {
                    ok = false;
                    if (showErrors) errName.classList.remove('hidden');
                } else errName.classList.add('hidden');

                if (!inputContact.value.trim()) {
                    ok = false;
                    if (showErrors) errContact.classList.remove('hidden');
                } else errContact.classList.add('hidden');

                if (!isEmailValid(inputEmail.value.trim())) {
                    ok = false;
                    if (showErrors) errEmail.classList.remove('hidden');
                } else errEmail.classList.add('hidden');

                if (!inputUpt.value) {
                    ok = false;
                    if (showErrors) errUpt.classList.remove('hidden');
                } else errUpt.classList.add('hidden');

                if (!inputLayanan.value) {
                    ok = false;
                    if (showErrors) errLayanan.classList.remove('hidden');
                } else errLayanan.classList.add('hidden');

                // experience optional for positive review (rating > 3)
                errExperience.classList.add('hidden');

                return ok;
            }

            // to-create redirect (rating 1..3)
            toCreateBtn.addEventListener('click', () => {
                if (!validateRequired()) {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                    return;
                }

                const params = new URLSearchParams();
                params.set('pelapor_nama', inputName.value.trim());
                params.set('pelapor_contact', inputContact.value.trim());
                params.set('email', inputEmail.value.trim());
                params.set('rating', ratingInput.value || '');
                if (inputUpt.value) params.set('upt_id', inputUpt.value);
                if (inputLayanan.value) params.set('jenis_layanan_id', inputLayanan.value);
                // experience not sent here because it's not visible for rating 1..3 in this flow
                window.location.href = "{{ route('pengaduan.create') }}" + (params.toString() ? ('?' +
                    params.toString()) : '');
            });

            // submit for positive review (rating > 3)
            form.addEventListener('submit', (e) => {
                const rv = parseInt(ratingInput.value || 0);
                if (rv <= 3) {
                    e.preventDefault();
                    alert(
                        'Pilih minimal 4 bintang untuk mengirim ulasan positif, atau pilih "Lanjut Isi Pengaduan".'
                    );
                    return;
                }
                if (!validateRequired()) {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                    return;
                }
                sendBtn.disabled = true;
                sendBtn.textContent = 'Mengirim...';
            });

            // live validation: show to-create when rating 1..3 and fields valid
            [inputName, inputContact, inputEmail, inputUpt, inputLayanan, experienceInput].forEach(el => el
                .addEventListener('input', () => {
                    const rv = parseInt(ratingInput.value || 0);
                    if (rv > 0 && rv <= 3) {
                        if (validateRequired(false)) toCreateBtn.classList.remove('hidden');
                    }
                }));

            // preload old rating if any
            const pre = parseInt(ratingInput.value || 0);
            if (pre) applyRating(pre);
        });
    </script>

    {{-- SweetAlert2 success popup (components.alert provides Swal lib/setup) --}}
    @if (session('ok'))
        <script>
            // Wait for Swal to be available (components.alert should include it)
            // (function showOk() {
            //     if (typeof Swal === 'undefined') {
            //         // try again shortly
            //         return setTimeout(showOk, 500);
            //     }
            //     Swal.fire({
            //         icon: 'success',
            //         title: 'Terima kasih!',
            //         text: {!! json_encode(session('ok')) !!},
            //         confirmButtonColor: '#059669'
            //     });
            // })();

            (function waitForSwal() {
                if (typeof Swal === 'undefined') {
                    return setTimeout(waitForSwal, 500);
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Terima kasih!',
                    text: {!! json_encode(session('ok')) !!},
                    confirmButtonColor: '#059669',
                    timer: 2000,
                    timerProgressBar: true,
                }).then(() => {
                    // Auto redirect setelah swal selesai
                    window.location.href = "{{ session('auto_redirect') }}";
                });

            })();
        </script>
    @endif


</body>

</html>
