<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LayananDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Asumsi: user layanan punya kolom `layanan_id` yang menunjuk ke table jenis_layanan
        // Jika Anda memakai relasi many-to-many, ganti bagian ini menjadi array id layanan.
        $layananId = $user->layanan_id ?? null;
        abort_unless($layananId, 403, 'Akun layanan belum terhubung ke Jenis Layanan.');

        // Filter tanggal (default 30 hari terakhir)
        $from = $request->date('from') ?: now()->subDays(30)->startOfDay();
        $to   = $request->date('to')   ?: now()->endOfDay();

        $base = Pengaduan::query()
            ->where('admin_layanan_id', $user->layanan_id)
            ->whereBetween('created_at', [$from, $to]);

        // Ringkasan
        $total     = (clone $base)->count();
        $menunggu  = (clone $base)->where('status', Pengaduan::STATUS_DISPOSISI)->count();
        // $diproses  = (clone $base)->where('status', Pengaduan::STATUS_DISPOSISI)->count();
        $selesai   = (clone $base)->where('status', Pengaduan::STATUS_SELESAI)->count();

        // Tabel terbaru (paginate 7)
        $recent = (clone $base)
            ->with(['unit','kategori','jenisLayanan'])
            ->latest('id')
            ->paginate(7)
            ->withQueryString();

        // Data chart
        $chart = [
            'labels' => ['Menunggu',  'Selesai'],
            'data'   => [$menunggu,  $selesai],
        ];

        $title = 'Beranda Layanan';

        return view('layanan.beranda.index', compact('title','from','to','total','menunggu','selesai','recent','chart'));
    }
}

