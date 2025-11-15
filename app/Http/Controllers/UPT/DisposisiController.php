<?php

namespace App\Http\Controllers\UPT;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use App\Models\PengaduanLog;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Gate;
use App\Mail\PengaduanAnsweredMail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UPT\JawabanStoreRequest;
use Illuminate\Validation\ValidationException;

class DisposisiController extends Controller
{
    // Disposisikan ke user_layanan
    public function index(Request $request)
    {
        $user = $request->user();

        // default: tampilkan hanya "menunggu"
        // $statuses = $request->boolean('show_disposisi')
        //     [Pengaduan::STATUS_MENUNGGU, Pengaduan::STATUS_DISPOSISI]
        //     : [Pengaduan::STATUS_MENUNGGU];

        // UPT\DisposisiController@index
        $statuses = [
            Pengaduan::STATUS_MENUNGGU,
            Pengaduan::STATUS_DISPOSISI,
        ];
        $items = Pengaduan::query()
            ->where('unit_id', $user->unit_id)
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

        return view('upt.disposisi.index', compact('items','userLayanan'));
    }

    // Tarik kembali (dari user layanan ke UPT)
    public function recall(Request $request, Pengaduan $pengaduan)
    {
        if ($pengaduan->status !== Pengaduan::STATUS_DISPOSISI) {
        return back()->with('warning', 'Pengaduan tidak dalam status disposisi.');
        }

        // >> UPDATE TABEL PENGADUANS
        $pengaduan->update([
            'admin_layanan_id' => null,
            'status'           => Pengaduan::STATUS_MENUNGGU,
        ]);

        PengaduanLog::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => $request->user()->id,
            'type'         => 'tarik_kembali',
            'status_after' => Pengaduan::STATUS_MENUNGGU,
            'note'         => $request->get('note'),
        ]);

        return back()->with('success', 'Pengaduan ditarik kembali (menunggu).');
    }

    // Jawab/selesaikan oleh admin UPT
    // public function jawab(JawabanStoreRequest $request, Pengaduan $pengaduan)
    // {
    //     if (
    //         optional($request->user()->role)->name !== 'admin_upt' ||
    //         (int) $request->user()->unit_id !== (int) $pengaduan->unit_id
    //     ) {
    //         abort(403);
    //     }


    //     $path = null;
    //     if ($request->hasFile('dokumen_penyelesaian')) {
    //         $path = $request->file('dokumen_penyelesaian')->store('pengaduan/dokumen','public');
    //     }

    //     $pengaduan->update([
    //         'admin_upt_id' => $request->user()->id,
    //         'hasil_tindaklanjut' => $request->hasil_tindaklanjut,
    //         'petugas_nama' => $request->petugas_nama,
    //         'dokumen_penyelesaian' => $path ?? $pengaduan->dokumen_penyelesaian,
    //         'status' => Pengaduan::STATUS_SELESAI,
    //         'tanggal_selesai' => now(),
    //     ]);

    //     PengaduanLog::create([
    //         'pengaduan_id' => $pengaduan->id,
    //         'user_id' => $request->user()->id,
    //         'type' => 'jawab',
    //         'status_after' => Pengaduan::STATUS_SELESAI,
    //         'note' => 'Ditutup oleh admin UPT',
    //         'meta' => null,
    //     ]);

    //     return back()->with('success', 'Pengaduan selesai dijawab.');
    // }

    public function jawab(JawabanStoreRequest $request, Pengaduan $pengaduan)
    {
    // pastikan hanya admin_upt yg boleh menjawab untuk unit terkait
    if (
        optional($request->user()->role)->name !== 'admin_upt' ||
        (int) $request->user()->unit_id !== (int) $pengaduan->unit_id
    ) {
        abort(403);
    }

    $path = null;
    $publicUrl = null;

    if ($request->hasFile('dokumen_penyelesaian')) {
        $file = $request->file('dokumen_penyelesaian');

        if ($file && $file->isValid()) {
            // simpan ke disk custom 'upload_disk'
            $path = $file->store('pengaduan/dokumen', config('filesystems.default_public_disk'));

            // buat URL publik manual (driver local)
            $publicUrl = rtrim(env('APP_URL'), '/') . '/storage/' . ltrim($path, '/');

            // optional: hapus file lama jika ada (aman-cek)
            if (!empty($pengaduan->dokumen_penyelesaian) && Storage::disk(config('filesystems.default_public_disk'))->exists($pengaduan->dokumen_penyelesaian)) {
                try {
                    Storage::disk(config('filesystems.default_public_disk'))->delete($pengaduan->dokumen_penyelesaian);
                } catch (\Throwable $delEx) {
                    Log::warning('Failed to delete old dokumen_penyelesaian', [
                        'old_path' => $pengaduan->dokumen_penyelesaian,
                        'error' => $delEx->getMessage(),
                    ]);
                }
            }
        }
    }

    // update data pengaduan
    $pengaduan->update([
        'admin_upt_id' => $request->user()->id,
        'hasil_tindaklanjut' => $request->hasil_tindaklanjut,
        'petugas_nama' => $request->petugas_nama,
        // simpan path file (string) — tetap gunakan path jika upload baru, atau biarkan apa yang ada
        'dokumen_penyelesaian' => $path ?? $pengaduan->dokumen_penyelesaian,
        // jika kamu punya kolom URL terpisah, simpan juga:
        // 'dokumen_penyelesaian_url' => $publicUrl ?? $pengaduan->dokumen_penyelesaian_url,
        'status' => Pengaduan::STATUS_SELESAI,
        'tanggal_selesai' => now(),
    ]);

    // catat log
    PengaduanLog::create([
        'pengaduan_id' => $pengaduan->id,
        'user_id' => $request->user()->id,
        'type' => 'jawab',
        'status_after' => Pengaduan::STATUS_SELESAI,
        'note' => 'Ditutup oleh admin UPT',
        'meta' => null,
    ]);

    // ==== kirim notifikasi email ke pelapor (jika ada) ====
    try {
        if (!empty($pengaduan->email)) {
            // synchronous send; jika nanti mau queue, ganti ->send() ke ->queue()
            Mail::to($pengaduan->email)->send(new PengaduanAnsweredMail($pengaduan));

            Log::info('Pengaduan answered email sent by admin_upt', [
                'pengaduan_id' => $pengaduan->id,
                'email' => $pengaduan->email,
                'admin_upt_id' => $request->user()->id,
            ]);
        } else {
            Log::info('Pengaduan answered - no email', ['pengaduan_id' => $pengaduan->id]);
        }
    } catch (\Throwable $mailEx) {
        // JANGAN rollback DB - cukup log error agar bisa ditindaklanjuti
        Log::error('Failed sending answered email (admin_upt)', [
            'pengaduan_id' => $pengaduan->id,
            'email' => $pengaduan->email,
            'error' => $mailEx->getMessage(),
        ]);
    }

    return back()->with('success', 'Pengaduan selesai dijawab.');
}


    // Disposisikan ke user_layanan
    public function store(Request $request, Pengaduan $pengaduan)
    {
        // pastikan admin UPT yang berwenang terhadap pengaduan ini
        if (
            optional($request->user()->role)->name !== 'admin_upt' ||
            (int) $request->user()->unit_id !== (int) $pengaduan->unit_id
        ) {
            abort(403);
        }
        $adminLayananId = (int) $request->admin_layanan_id;

            $valid = User::where('id', $adminLayananId)
                ->where('unit_id', $request->user()->unit_id)
                ->whereHas('role', fn($q) => $q->where('name','admin_layanan'))
                ->exists();

            if (!$valid) {
                throw ValidationException::withMessages([
                    'admin_layanan_id' => 'User layanan tidak valid untuk unit ini.',
                ]);
            }

            // >> UPDATE TABEL PENGADUANS
            $pengaduan->update([
                'admin_upt_id'      => $request->user()->id,
                'admin_layanan_id'  => $adminLayananId,
                'status'            => Pengaduan::STATUS_DISPOSISI,
            ]);

            PengaduanLog::create([
                'pengaduan_id' => $pengaduan->id,
                'user_id'      => $request->user()->id,
                'type'         => 'disposisi',
                'status_after' => Pengaduan::STATUS_DISPOSISI,
                'note'         => $request->note,
                'meta'         => ['to_user_layanan_id' => $adminLayananId],
            ]);

            return back()->with('success', 'Pengaduan didisposisikan ke user layanan.');
    }

    public function show(Request $request, Pengaduan $pengaduan)
    {
        if (
            optional($request->user()->role)->name !== 'admin_upt' ||
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

        return view('upt.disposisi.show', [
            'item' => $pengaduan,
            // 'buktiList' => $buktiList,
            'title' => 'Detail Pengaduan ' . $pengaduan->no_tiket,
        ]);
    }
}