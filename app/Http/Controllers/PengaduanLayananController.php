<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Pengaduan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanLayananController extends Controller
{
    public function index(Request $request)
    {
        // pastikan sudah login dan punya unit_id + layanan_id
        if (!Auth::check()) {
            abort(403, 'Unauthorized.');
        }

        $user = Auth::user();

        // pastikan user memiliki unit dan layanan terkait
        if (empty($user->unit_id) || empty($user->layanan_id)) {
            abort(403, 'Akun Anda belum terhubung ke UPT / Layanan yang valid.');
        }

        // bangun query awal dan batasi langsung ke unit + layanan user
        $query = Pengaduan::query()
            ->with(['unit', 'kategori', 'jenisLayanan', 'latestLog'])
            ->where('unit_id', $user->unit_id)
            ->where('admin_layanan_id', $user->admin_layanan_id);

        // kunci filter di request agar tidak bisa diubah dari UI
        $request->merge([
            'unit_id' => $user->unit_id,
            'admin_layanan_id' => $user->admin_layanan_id,
        ]);

        // Pencarian umum
        if ($search = trim((string) $request->get('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'like', "%{$search}%")
                ->orWhere('judul', 'like', "%{$search}%")
                ->orWhere('pelapor_nama', 'like', "%{$search}%")
                ->orWhere('pelapor_contact', 'like', "%{$search}%");
            });
        }

        // Filter tambahan (masih di dalam cakupan unit+layanan)
        if ($status = trim((string) $request->get('status'))) {
            $query->where('status', $status);
        }
        if ($asal = trim((string) $request->get('asal_pengaduan'))) {
            $query->where('asal_pengaduan', $asal);
        }
        if ($from = $request->date('from')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->date('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        // paginate
        $pengaduans = $query->latest('id')->paginate(15)->withQueryString();

        // Data dropdown: karena kita mengunci unit & layanan, untuk unit tampilkan hanya unit user
        $lockedUnit = Unit::find($user->unit_id);
        $units = $lockedUnit ? collect([$lockedUnit]) : Unit::orderBy('name')->get(['id','name']);
        $jenisLayanans = JenisLayanan::orderBy('nama')->get(['id','nama']);

        // statuses: sesuaikan jika perlu
        $statuses = [
            Pengaduan::STATUS_DISPOSISI,
        ];

        $title = 'Daftar Pengaduan';

        return view('layanan.pengaduan.index', compact(
            'title', 'pengaduans', 'units', 'jenisLayanans', 'statuses', 'lockedUnit'
        ));
    }

 public function show(Request $request, Pengaduan $pengaduan)
    {
        if (
            optional($request->user()->role)->name !== 'admin_layanan' ||
            (int) $request->user()->unit_id !== (int) $pengaduan->unit_id
        ) {
            abort(403);
        }
        $pengaduan->load([
            'adminUpt',
            'adminLayanan',
            'logs' => fn ($q) => $q->latest(),
            'logs.user',
        ]);

        return view('layanan.pengaduan.show', [
            'item' => $pengaduan,
            // 'buktiList' => $buktiList,
            'title' => 'Detail Pengaduan ' . $pengaduan->no_tiket,
        ]);
    }   

}
