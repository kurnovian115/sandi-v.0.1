<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

    // Ambil input sebagai string dari query (GET)
    $fromInput = $request->query('from');
    $toInput   = $request->query('to');

    // Parse dengan Carbon — jika gagal, pakai default (30 hari terakhir)
    try {
        $from = $fromInput ? Carbon::createFromFormat('Y-m-d', $fromInput)->startOfDay() : now()->subDays(30)->startOfDay();
        // dd($from);
    } catch (\Throwable $e) {
        $from = now()->subDays(30)->startOfDay();
    }

    try {
        $to = $toInput ? Carbon::createFromFormat('Y-m-d', $toInput)->endOfDay() : now()->endOfDay();
    } catch (\Throwable $e) {
        $to = now()->endOfDay();
    }

    // Pastikan dd dihapus — dd akan menghentikan proses
    // dd($to);

    $base = Pengaduan::query()
        ->where('unit_id', $unitId)
        ->whereBetween('created_at', [$from, $to]);

    // Kartu ringkasan
    $total       = (clone $base)->count();
    $menunggu    = (clone $base)->where('status', Pengaduan::STATUS_MENUNGGU)->count();
    $disposisi   = (clone $base)->where('status', Pengaduan::STATUS_DISPOSISI)->count();
    $selesai     = (clone $base)->where('status', Pengaduan::STATUS_SELESAI)->count();

    // Data terbaru paginate 7 (pertahankan query string)
    $recent = (clone $base)
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
