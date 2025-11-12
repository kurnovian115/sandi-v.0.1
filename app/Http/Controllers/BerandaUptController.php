<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaUptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
    {
        $user = Auth::user();
        abort_unless($user && $user->unit_id, 403, 'Dashboard UPT memerlukan akun dengan unit_id.');

        $unitId = (int) $user->unit_id;

        // Filter tanggal (default 30 hari terakhir)
        $from = $request->date('from') ?: now()->subDays(30)->startOfDay();
        $to   = $request->date('to')   ?: now()->endOfDay();

        $base = Pengaduan::query()
            ->where('unit_id', $unitId)
            ->whereBetween('created_at', [$from, $to]);

        // Kartu ringkasan
        $total       = (clone $base)->count();
        $menunggu    = (clone $base)->where('status', Pengaduan::STATUS_MENUNGGU)->count();
        $disposisi   = (clone $base)->where('status', Pengaduan::STATUS_DISPOSISI)->count();
        $selesai     = (clone $base)->where('status', Pengaduan::STATUS_SELESAI)->count();

        // Data terbaru paginate 7
        $recent = (clone $base)
            ->with(['jenisLayanan','kategori'])
            ->latest('id')
            ->paginate(7)
            ->withQueryString();

        // Data chart tunggal: jumlah per status
        $chart = [
            'labels' => ['Menunggu', 'Diproses', 'Selesai'],
            'data'   => [$menunggu, $disposisi, $selesai],
        ];

        $title = 'Dashboard UPT';

        return view('upt.beranda.index', compact(
            'title','from','to','total','menunggu','disposisi','selesai','recent','chart'
        ));
    }
}
