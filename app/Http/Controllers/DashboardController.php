<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Unit;
use App\Models\KategoriPengaduan;
use App\Models\Pengaduan;
// use Illuminate\Support\Facades\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard Kanwil
     */
   public function index(Request $request)
    {
        // -----------------------
        // Filters (bulan/start-end)
        // -----------------------
        $start = $request->input('start');
        $end   = $request->input('end');

        $startDate = $start ? Carbon::parse($start.'-01')->startOfMonth() : Carbon::now()->startOfYear();
        $endDate   = $end ? Carbon::parse($end.'-01')->endOfMonth() : Carbon::now()->endOfMonth();

        $unitId     = $request->input('unit_id');
        $kategoriId = $request->input('kategori_id');
        $layananId = $request->input('layanan_id');

        // Base query dengan filter + prefix created_at biar tidak ambiguous
        $base = Pengaduan::query()
            ->when($unitId, fn($q) => $q->where('unit_id', $unitId))
            ->when($kategoriId, fn($q) => $q->where('kategori_id', $kategoriId))
            ->when($layananId, fn($q)=> $q->where('jenis_layanan_id', $layananId))
            ->whereBetween('pengaduans.created_at', [$startDate, $endDate]);

        // -----------------------
        // KPI cards
        // -----------------------
        $stat = [
            'total'   => (clone $base)->count(),
            'proses'  => (clone $base)->whereIn('status', ['Menunggu'])->count(),            
            'disposisi' => (clone $base)->where('status','Disposisi ke layanan')->count(),
            'selesai' => (clone $base)->where('status', 'Selesai')->count(),
        ];

        // -----------------------
        // Dropdown filters data
        // -----------------------
        $upts     = Unit::orderBy('name')->get(['id','name']); 
        // dd($upts);
        // Unit::orderBy('name')->get(['id','name']);
        $kategori = KategoriPengaduan::orderBy('id')->get(['id','nama']);
        $layanans = JenisLayanan::orderBy('id')->get();

        // -----------------------
        // Latest (alias no_tiket -> kode) + prefix created_at
        // -----------------------
        $latest = (clone $base)
            ->leftJoin('units', 'units.id', '=', 'pengaduans.unit_id')
            ->orderByDesc('pengaduans.created_at')
            ->select([
                'pengaduans.id',
                DB::raw('pengaduans.no_tiket as kode'),
                'pengaduans.judul',
                'pengaduans.status',
                'pengaduans.created_at',
                DB::raw('units.name as unit_nama'),
            ])
        ->paginate(7)              // <- ganti get() jadi paginate()
        ->withQueryString();        // <- supaya filter di URL tetap kepasang


        // -----------------------
        // Ambil data mentah periode ini sekali saja
        // untuk dihitung di PHP (aman untuk SQLite)
        // -----------------------
        $raw = (clone $base)->get([
            'id','unit_id','kategori_id','jenis_layanan_id','created_at'
        ]);

        // -----------------------
        // Labels bulan
        // -----------------------
        $monthLabels = [];
        $cursor = (clone $startDate)->startOfMonth();
        while ($cursor <= $endDate) {
            $monthLabels[] = $cursor->translatedFormat('M Y'); // ex: Jan 2025
            $cursor->addMonth();
        }
        $monthKeys = []; // map YYYY-MM -> index
        $cursor = (clone $startDate)->startOfMonth();
        $i = 0;
        while ($cursor <= $endDate) {
            $monthKeys[$cursor->format('Y-m')] = $i++;
            $cursor->addMonth();
        }

        // -----------------------
        // Trend per bulan per UPT (Line)
        // -----------------------
        $trendUnits = Unit::orderBy('name')->get(['id','name'])->toArray();
        $trendMonthlyByUnit = array_fill(0, count($trendUnits), array_fill(0, count($monthLabels), 0));

        foreach ($raw as $row) {
            $ym = Carbon::parse($row->created_at)->format('Y-m');
            if (!isset($monthKeys[$ym])) continue;
            $mIdx = $monthKeys[$ym];
            // cari index unit
            foreach ($trendUnits as $uIdx => $u) {
                if ((int)$u['id'] === (int)$row->unit_id) {
                    $trendMonthlyByUnit[$uIdx][$mIdx]++;
                    break;
                }
            }
        }

        // -----------------------
        // Bar: jumlah pengaduan per UPT
        // -----------------------
        $barTmp = (clone $base)
            ->leftJoin('units', 'units.id', '=', 'pengaduans.unit_id')
            ->groupBy('units.name')
            ->orderBy('units.name')
            ->get([
                DB::raw('units.name as name'),
                DB::raw('COUNT(pengaduans.id) as total'),
            ]);

        $barLabels = $barTmp->pluck('name')->all();
        $barData   = $barTmp->pluck('total')->map(fn($v)=>(int)$v)->all();

        // -----------------------
        // Pie: komposisi per jenis layanan
        // -----------------------
        $pieTmp = (clone $base)
            ->leftJoin('jenis_layanan', 'jenis_layanan.id', '=', 'pengaduans.jenis_layanan_id')
            ->groupBy('jenis_layanan.nama')
            ->orderBy('jenis_layanan.nama')
            ->get([
                DB::raw('COALESCE(jenis_layanan.nama, "Tidak Diisi") as name'),
                DB::raw('COUNT(pengaduans.id) as total'),
            ]);
        $pieLabels = $pieTmp->pluck('name')->all();
        $pieData   = $pieTmp->pluck('total')->map(fn($v)=>(int)$v)->all();

        // -----------------------
        // Donut: kategori pengaduan
        // -----------------------

        $catTmp = (clone $base)
       
            ->leftJoin('kategori_pengaduan', 'kategori_pengaduan.id', '=', 'pengaduans.kategori_id')
            ->groupBy('kategori_pengaduan.nama')
            ->orderBy('kategori_pengaduan.nama')
            ->get([
                DB::raw('COALESCE(kategori_pengaduan.nama, "Tidak Diisi") as name'),
                DB::raw('COUNT(pengaduans.id) as total'),
            ]);
            
        $catLabels = $catTmp->pluck('name')->all();
        $catData   = $catTmp->pluck('total')->map(fn($v)=>(int)$v)->all();
            
        return view('kanwil.beranda.index', [
            'title' => 'Beranda — Admin Kanwil',
            'stat' => $stat,
            'upts' => $upts,
            'kategori' => $kategori,
            'layanans' => $layanans,
            'latest' => $latest,
            'trendMonthLabels' => $monthLabels,
            'trendDataByUnitMonthly' => $trendMonthlyByUnit,
            'trendUnits' => array_column($trendUnits, 'name'),
            'barLabels' => $barLabels,
            'barData'   => $barData,
            'pieLabels' => $pieLabels,
            'pieData'   => $pieData,
            'catLabels' => $catLabels,
            'catData'   => $catData,
        ]);
    }
}