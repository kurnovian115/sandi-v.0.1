<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Notifikasi Pengaduan - SANDI JABAR</title>
    <style>
        body {
            background: #eef6fa;
            margin: 0;
            padding: 30px 10px;
            -webkit-text-size-adjust: none;
        }

        .email-wrap {
            max-width: 680px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(16, 24, 40, 0.04);
        }

        .header {
            background: #0f172a;
            color: #fff;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            width: 44px;
            height: 44px;
            object-fit: contain;
            border-radius: 6px;
            background: #fff;
            padding: 4px;
        }

        .brand {
            font-weight: 700;
            font-size: 18px;
        }

        .body {
            padding: 26px;
            color: #111827;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }

        .panel {
            display: inline-block;
            background: #f3f4f6;
            border-radius: 8px;
            padding: 10px 16px;
            font-weight: 700;
            color: #0f172a;
            margin: 12px auto;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 13px;
            color: #fff;
        }

        .btn {
            display: inline-block;
            padding: 11px 22px;
            background: #0f172a;
            color: #fff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
        }

        .muted {
            color: #6b7280;
            font-size: 13px;
        }

        .list {
            margin: 8px 0 14px 18px;
        }

        @media (max-width:480px) {
            .body {
                padding: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="email-wrap">
        {{-- Header --}}
        <div class="header">
            {{-- <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }} Logo" class="logo" /> --}}
            {{-- <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png"> --}}
            <div>
                <div class="brand">SANDI JABAR</div>
                <div class="muted" style="font-size:12px; margin-top:2px;">Notifikasi Pengaduan</div>
            </div>
        </div>

        {{-- Body --}}
        <div class="body">
            <h2 style="margin:0 0 10px 0;">Pengaduan Anda Telah Diterima</h2>

            <p class="muted">Yth. {{ $pengaduan->pelapor_nama ?? 'Bapak/Ibu' }},</p>

            <p>
                Terima kasih telah menggunakan layanan <strong>{{ config('app.name') }}</strong>.
                Pengaduan Anda telah berhasil kami terima dan tercatat dalam sistem. Berikut informasi singkat terkait
                pengaduan Anda:
            </p>

            {{-- Nomor tiket (tengah) --}}
            {{-- Tiket Section --}}
            <div style="text-align:center; margin:20px 0;">
                <div
                    style="
        display:inline-block;
        padding:16px 22px;
        border-radius:10px;
        font-size:20px;
        font-weight:700;
        background:linear-gradient(135deg,#dbeafe,#bfdbfe);
        color:#0f172a;
        box-shadow:0 1px 4px rgba(0,0,0,0.08);
        margin-bottom:10px;
    ">
                    {{ $pengaduan->no_tiket }}
                </div>
            </div>


            {{-- Status badge --}}
            @php
                $status = strtolower($pengaduan->status ?? 'menunggu');
                $color = '#6b7280';
                if (str_contains($status, 'menunggu')) {
                    $color = '#f59e0b';
                }
                if (str_contains($status, 'disposisi') || str_contains($status, 'proses')) {
                    $color = '#0ea5a6';
                }
                if (str_contains($status, 'selesai')) {
                    $color = '#10b981';
                }
            @endphp

            <div style="text-align:left; margin:12px 0 18px;">

                <span class="status-badge" style="background:{{ $color }};">
                    Status : {{ ucfirst($pengaduan->status) }}
                </span>
            </div>

            {{-- Detail --}}
            <h4 style="margin:12px 0 6px 0;">Detail Pengaduan</h4>
            <ul class="list">
                <li><strong>Judul:</strong> {{ $pengaduan->judul }}</li>
                <li><strong>Waktu Pengajuan:</strong> {{ $pengaduan->created_at->format('d M Y H:i') }}</li>
                <li><strong>No. Kontak Pelapor:</strong> {{ $pengaduan->pelapor_contact }}</li>
            </ul>

            <p>
                Untuk memantau perkembangan penanganan pengaduan, silakan gunakan tombol berikut.
                Pastikan Anda menyimpan nomor tiket sebagai bukti dan referensi pelacakan.
            </p>

            {{-- Tombol (tengah) --}}
            <div style="text-align:center; margin:20px 0;">
                <a class="btn" href="{{ url('/pengaduan/track') }}">Lacak Pengaduan</a>
            </div>

            <p class="muted" style="text-align:center;">
                Atau buka: <a href="{{ url('/pengaduan/track') }}">{{ url('/pengaduan/track') }}</a>
            </p>

            <p style="margin-top:20px;">
                Terima kasih atas kepercayaan Anda dalam membantu kami meningkatkan kualitas layanan.
            </p>

            <p style="margin-top:16px;">
                Salam hormat,<br>
                <strong>{{ config('app.name') }}</strong>
            </p>
        </div>
    </div>
</body>

</html>
