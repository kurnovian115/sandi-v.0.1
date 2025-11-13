<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaduan;
use App\Models\PengaduanLog;
use Illuminate\Http\Request;

use App\Http\Requests\UPT\JawabanStoreRequest;

class PengaduanMasukController extends Controller
{
     public function index(Request $request)
    {
        $user = $request->user();

        $statuses = [
            Pengaduan::STATUS_DISPOSISI,
        ];
        $items = Pengaduan::query()
            ->where('unit_id', $user->unit_id)
            ->where('admin_layanan_id', $user->id)
            ->whereIn('status', $statuses)
            ->when($request->filled('q'), function ($q) use ($request) {
                $s = $request->get('q');
                $q->where(fn($qq) => $qq
                    ->where('no_tiket','like',"%{$s}%")
                    ->orWhere('pelapor_nama','like',"%{$s}%")
                    ->orWhere('judul','like',"%{$s}%"));
            })
            ->latest()
            ->paginate(7)
            ->withQueryString();

        $userLayanan = User::query()
            ->where('unit_id', $user->unit_id)
            ->whereRelation('role', 'name', 'admin_layanan')
            ->orderBy('name')
            ->get(['id','name','layanan_id']); // kalau perlu nama layanan

        return view('layanan.pengaduan.inbox.index', compact('items','userLayanan'));
    }

    public function jawab(JawabanStoreRequest $request, Pengaduan $pengaduan)
    {
        
        if (
            optional($request->user()->role)->name !== 'admin_layanan' ||
            (int) $request->user()->unit_id !== (int) $pengaduan->unit_id
        ) {
            abort(403);
        }

        $path = null;
        if ($request->hasFile('dokumen_penyelesaian')) {
            $path = $request->file('dokumen_penyelesaian')->store('pengaduan/dokumen','public');
        }
        $pengaduan->update([
            'admin_upt_id' => $request->user()->id,
            'hasil_tindaklanjut' => $request->hasil_tindaklanjut,
            'petugas_nama' => $request->petugas_nama,
            'dokumen_penyelesaian' => $path ?? $pengaduan->dokumen_penyelesaian,
            'status' => Pengaduan::STATUS_SELESAI,
            'tanggal_selesai' => now(),
        ]);

        PengaduanLog::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id' => $request->user()->id,
            'type' => 'jawab',
            'status_after' => Pengaduan::STATUS_SELESAI,
            'note' => 'Ditutup oleh admin UPT',
            'meta' => null,
        ]);

        return back()->with('success', 'Pengaduan selesai dijawab.');
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

        return view('layanan.pengaduan.inbox.show', [
            'item' => $pengaduan,
            // 'buktiList' => $buktiList,
            'title' => 'Detail Pengaduan ' . $pengaduan->no_tiket,
        ]);
    }
}
