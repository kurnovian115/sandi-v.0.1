<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaduan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class UptPengaduanController extends Controller
{
public function index(Request $request)
{
    $title  = 'Monitoring & Verifikasi Pengaduan (Admin UPT)';
    $unitId = optional(Auth::user())->unit_id;

    $q      = (string) $request->get('q', '');
    $status = $request->get('status');      // menunggu|proses|selesai|ditolak
    $start  = $request->get('start');       // YYYY-MM[-DD]
    $end    = $request->get('end');         // YYYY-MM[-DD]

    // Lookup dropdown
    $layanans = DB::table('jenis_layanan')->orderBy('nama')->get(['id','nama']);
    // Ambil semua user yang punya jenis_layanan_id (kalau mau, bisa ditambah filter role)
    $petugas  = DB::table('users')
        ->whereNotNull('jenis_layanan_id')
        ->orderBy('name')
        ->get(['id','name','jenis_layanan_id']);

    // Subquery tanggal disposisi pertama (log type = 'assignment')
    $assignSub = DB::table('pengaduan_logs')
        ->select('pengaduan_id', DB::raw('MIN(created_at) as first_assign_at'))
        ->where('type', 'assignment')
        ->groupBy('pengaduan_id');

    // Daftar pengaduan utk UPT ini, latest
    $list = DB::table('pengaduans as p')
        ->leftJoin('users as admin', 'admin.id', '=', 'p.admin_layanan_id')
        ->leftJoin('jenis_layanan as jl', 'jl.id', '=', 'p.jenis_layanan_id')
        ->leftJoinSub($assignSub, 'pl', function($join){
            $join->on('pl.pengaduan_id', '=', 'p.id');
        })
        ->leftJoin('units as u', 'u.id', '=', 'p.unit_id')
        ->when($unitId, fn($qq) => $qq->where('p.unit_id', $unitId))
        ->when($q, function ($qq) use ($q) {
            $qq->where(function ($w) use ($q) {
                $w->where('p.judul','like',"%{$q}%")
                  ->orWhere('p.no_tiket','like',"%{$q}%");
            });
        })
        ->when($status, fn($qq) => $qq->where('p.status', $status))
        ->when($start, function ($qq) use ($start) {
            $s = strlen($start) === 7 ? ($start.'-01') : $start;
            $qq->whereDate('p.created_at', '>=', $s);
        })
        ->when($end, function ($qq) use ($end) {
            $e = strlen($end) === 7 ? date('Y-m-t', strtotime($end.'-01')) : $end;
            $qq->whereDate('p.created_at', '<=', $e);
        })
        ->orderByDesc('p.created_at')
        ->select([
            'p.id',
            DB::raw('p.no_tiket as kode'),
            'p.judul',
            'p.status',
            'p.created_at',
            'p.tanggal_selesai',
            DB::raw('COALESCE(u.name, "-") as unit_nama'),
            DB::raw('COALESCE(jl.nama, "-") as layanan_nama'),
            DB::raw('admin.name as admin_nama'),
            DB::raw('pl.first_assign_at as disposisi_at'),
        ])
        ->paginate(20)
        ->withQueryString();

    return view('upt.pengaduan.index', compact(
        'title','list','q','status','start','end','layanans','petugas'
    ));
}

    // verifikasi & disposisi (dua mode): layanan atau self
    public function verifikasi(Request $request, $id)
    {
        $data = $request->validate([
            'mode'             => ['required','in:layanan,self'],
            'jenis_layanan_id' => ['nullable','exists:jenis_layanan,id'],
            'catatan'          => ['nullable','string','max:1000'],
        ]);

        if ($data['mode'] === 'layanan') {
            // Disposisi ke layanan (tanpa petugas)
            DB::table('pengaduans')->where('id', $id)->update([
                'jenis_layanan_id' => $data['jenis_layanan_id'],
                'admin_upt_id'     => Auth::id(), // yg menetapkan
                'status'           => 'proses',
                'updated_at'       => now(),
            ]);

            DB::table('pengaduan_logs')->insert([
                'pengaduan_id' => $id,
                'user_id'      => Auth::id(),
                'type'         => 'assignment',
                'status_after' => 'proses',
                'note'         => $data['catatan'] ?? null,
                'meta'         => json_encode([
                    'mode' => 'layanan',
                    'jenis_layanan_id' => $data['jenis_layanan_id'],
                ]),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        } else {
            // Tangani sendiri oleh admin UPT (tanpa layanan)
            DB::table('pengaduans')->where('id', $id)->update([
                'jenis_layanan_id' => null,
                'admin_upt_id'     => Auth::id(),
                'status'           => 'proses',
                'updated_at'       => now(),
            ]);

            DB::table('pengaduan_logs')->insert([
                'pengaduan_id' => $id,
                'user_id'      => Auth::id(),
                'type'         => 'assignment',
                'status_after' => 'proses',
                'note'         => $data['catatan'] ?? null,
                'meta'         => json_encode(['mode' => 'self']),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        return back()->with('success','Pengaduan diverifikasi.');
    }

    public function tolak(Request $request, $id)
    {
        $data = $request->validate([
            'alasan' => ['required','string','max:1000'],
        ]);

        DB::table('pengaduans')->where('id', $id)->update([
            'status'     => 'ditolak',
            'updated_at' => now(),
        ]);

        DB::table('pengaduan_logs')->insert([
            'pengaduan_id' => $id,
            'user_id'      => Auth::id(),
            'type'         => 'status',
            'status_after' => 'ditolak',
            'note'         => $data['alasan'],
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return back()->with('success','Pengaduan ditolak.');
    }
}