<?php

namespace App\Http\Controllers;

use App\Models\JenisLayanan;
use App\Models\KategoriPengaduan;
use App\Models\Unit;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KanwilPengaduanController extends Controller
{
   public function index(Request $request)
    {
        $title   = 'Monitoring Semua Pengaduan';
        $q       = (string) $request->get('q', '');
        $status  = $request->get('status');      // proses|selesai|ditolak
        $unitId  = $request->get('unit_id');
        $start   = $request->get('start');       // yyyy-mm[-dd]
        $end     = $request->get('end');

        $upts = Unit::query()->orderBy('name')->get(['id','name']);

        // Base filter
        $base = Pengaduan::query()
            ->with(['unit:id,name'])
            ->when($q, function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('judul', 'like', "%{$q}%")
                      ->orWhere('no_tiket', 'like', "%{$q}%");
                });
            })
            ->when($status, fn ($qq) => $qq->where('status', $status))
            ->when($unitId, fn ($qq) => $qq->where('unit_id', $unitId))
            ->when($start, function ($qq) use ($start) {
                $s = strlen($start) === 7 ? ($start . '-01') : $start; // dukung YYYY-MM
                $qq->whereDate('created_at', '>=', $s);
            })
            ->when($end, function ($qq) use ($end) {
                $e = strlen($end) === 7 ? date('Y-m-t', strtotime($end . '-01')) : $end;
                $qq->whereDate('created_at', '<=', $e);
            });

        // List dengan join admin layanan & jenis layanan
        $list = (clone $base)
            ->leftJoin('users as admin', 'admin.id', '=', 'pengaduans.admin_layanan_id')
            ->leftJoin('jenis_layanan as jl', 'jl.id', '=', 'admin.layanan_id') // sesuaikan nama tabel/kolom
            ->orderBy('pengaduans.created_at', 'desc') // latest
            ->select([
                'pengaduans.id',
                DB::raw('pengaduans.no_tiket as kode'),
                'pengaduans.judul',
                'pengaduans.status',
                DB::raw('pengaduans.created_at as masuk_at'),
                'pengaduans.tanggal_selesai',          // kalau belum ada kolom ini, hapus saja
                'pengaduans.unit_id',
                DB::raw('COALESCE(jl.nama, "-") as layanan_nama'),
                DB::raw('admin.name as admin_nama'),
            ])
            ->paginate(7)
            ->withQueryString();

        return view('kanwil.monitoring.index', compact(
            'title','list','q','status','unitId','start','end','upts'
        ));
    }
}
