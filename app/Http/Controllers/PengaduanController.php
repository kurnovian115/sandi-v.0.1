<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Unit;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use App\Models\JenisLayanan;
use App\Models\PengaduanLog;
use Illuminate\Http\Request;
use App\Models\KategoriPengaduan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePengaduanRequest;


class PengaduanController extends Controller
{
    /**
     * Show form tambah pengaduan (public).
     * Accept optional query param ?source=qr|media_sosial|email|telepon|e-lapor|langsung
     */

    public function upt(Request $request)
    {
        $query = Pengaduan::query()
        ->with(['unit', 'kategori', 'jenisLayanan', 'latestLog']);

        $lockedUnit = null;
        if (Auth::check()) {
            $user = Auth::user();

            // Asumsi: admin UPT punya kolom unit_id di tabel users
            // (ubah kondisinya kalau kamu pakai sistem role lain)
            if (!empty($user->unit_id)) {
                $query->where('unit_id', $user->unit_id);
                $lockedUnit = Unit::find($user->unit_id);

                // kunci nilai filter supaya tidak bisa diubah ke UPT lain
                $request->merge(['unit_id' => $user->unit_id]);
            }
        }

        // Pencarian umum
        if ($search = trim((string) $request->get('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('no_tiket', 'like', "%{$search}%")
                ->orWhere('judul', 'like', "%{$search}%")
                ->orWhere('pelapor_nama', 'like', "%{$search}%")
                ->orWhere('pelapor_contact', 'like', "%{$search}%");
            });
        }

        // Filter
        if ($unitId = $request->integer('unit_id')) {
            $query->where('unit_id', $unitId);
        }
        if ($layananId = $request->integer('jenis_layanan_id')) {
            $query->where('jenis_layanan_id', $layananId);
        }
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

        $pengaduans = $query->latest('id')->paginate(15)->withQueryString();

        // Data dropdown
        $units = $lockedUnit ? collect([$lockedUnit]) : Unit::orderBy('name')->get(['id','name']);
        $jenisLayanans = JenisLayanan::orderBy('nama')->get(['id','nama']);
        $statuses = [
            Pengaduan::STATUS_MENUNGGU,
            Pengaduan::STATUS_DISPOSISI,
            Pengaduan::STATUS_SELESAI,
        ];

        $title = 'Daftar Pengaduan';

        return view('upt.pengaduan.table.index', compact(
            'title', 'pengaduans', 'units', 'jenisLayanans', 'statuses', 'lockedUnit'
        ));
    }

   public function index(Request $request)
    {
        $query = Pengaduan::query()
        ->with(['unit', 'kategori', 'jenisLayanan', 'latestLog']);


        // Pencarian umum
        if ($search = trim((string) $request->get('q'))) {
        $query->where(function ($q) use ($search) {
        $q->where('no_tiket', 'like', "%{$search}%")
        ->orWhere('judul', 'like', "%{$search}%")
        ->orWhere('pelapor_nama', 'like', "%{$search}%")
        ->orWhere('pelapor_contact', 'like', "%{$search}%");
        });
        }


        // Filter
        if ($unitId = $request->integer('unit_id')) {
        $query->where('unit_id', $unitId);
        }
        if ($layananId = $request->integer('jenis_layanan_id')) {
        $query->where('jenis_layanan_id', $layananId);
        }
        if ($status = trim((string) $request->get('status'))) {
        $query->where('status', $status);
        }
        if ($asal = trim((string) $request->get('asal_pengaduan'))) {
        $query->where('asal_pengaduan', $asal);
        }
        // Rentang tanggal dibuat
        if ($from = $request->date('from')) {
        $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->date('to')) {
        $query->whereDate('created_at', '<=', $to);
        }


        $pengaduans = $query->latest('id')->paginate(15)->withQueryString();


        $units = Unit::query()->orderBy('name')->get(['id','name']);
        $jenisLayanans = JenisLayanan::query()->orderBy('nama')->get(['id','nama']);


        $statuses = [
        Pengaduan::STATUS_MENUNGGU,
        Pengaduan::STATUS_DISPOSISI,
        Pengaduan::STATUS_SELESAI,
        ];


        $title = 'Daftar Pengaduan';


        return view('pengaduan.index', compact(
            'title',
            'pengaduans',
            'units',
            'jenisLayanans',
            'statuses'
            ));
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::with([
        'unit',
        'kategori',
        'jenisLayanan',
        'adminUpt',
        'adminLayanan',
        'logs.user' // jika log ada relasi user
        ])->findOrFail($id);
        $title = "Detail Pengaduan — {$pengaduan->no_tiket}";

        return view('pengaduan.show', compact('pengaduan', 'title'));
    }

    public function create(Request $request)
    {
        $source = $request->query('source', 'qr');

        // tarik kategori & jenis layanan aktif untuk dropdown
        $kategoris = KategoriPengaduan::where('is_active', 1)->orderBy('id')->get();
        $layanans  = JenisLayanan::where('is_active', 1)->orderBy('id')->get();
        $upt  = Unit::where('is_active', 1)->orderBy('id')->get();

        return view('pengaduan.tambah', compact('kategoris', 'layanans', 'source', 'upt'));
    }

    public function store(StorePengaduanRequest $request)
    {
    $validated = $request->validate([
            'upt_id' => ['required', 'exists:units,id'],
            'kategori_id' => ['required', 'exists:kategori_pengaduan,id'],
            'jenis_layanan_id' => ['required', 'exists:jenis_layanan,id'],
            // 'upt_id' => ['required', 'exists:upt_id,id'],
            'judul' => ['required','string','max:100'],
            'deskripsi' => ['required','string'],
            'pelapor_nama' => ['required','string','max:191'],
            'pelapor_contact' =>  ['required','string','max:20','regex:/^(?:\+?62|0)\d{8,13}$/'],
            'email'           => ['required','email','max:150'],
            // 'bukti_masyarakat.*' => ['nullable','file','mimes:jpg,jpeg,png','max:2048'],
            // 'nama'            => ['required','string','max:100'],
            // 'telepon'         => ['required','string','max:20','regex:/^(?:\+?62|0)\d{8,13}$/'],
            // 'email'           => ['nullable','email','max:150'],
        ]);

        // Map upt_id (dari frontend) ke unit_id (kolom DB)
        $validated['unit_id'] = $validated['upt_id'];
        unset($validated['upt_id']);


        DB::beginTransaction();
        try {
            // generate tiket
            $noTiket = 'IMI-JBR-' . now()->format('YmdHis') . strtoupper(Str::random(3));

            $data = $validated;
            $data['no_tiket'] = $noTiket;
            $data['status'] = 'Menunggu';
            $data['sla_late'] = 0;

            // handle files
            $buktiArray = [];
            if ($request->hasFile('bukti_masyarakat')) {
                foreach ($request->file('bukti_masyarakat') as $f) {
                    $path = $f->store('pengaduan/bukti/' . date('Ymd'), 'public');
                    $buktiArray[] = [
                        'path' => $path,
                        'name' => $f->getClientOriginalName(),
                        'mime' => $f->getClientMimeType(),
                        'size' => $f->getSize(),
                    ];
                }
            }
            $data['bukti_masyarakat'] = $buktiArray ?: null;

            $pengaduan = Pengaduan::create($data);

            // buat initial log (pelapor publik => user_id null)
            PengaduanLog::create([
                'pengaduan_id' => $pengaduan->id,
                'user_id' => null,
                'type' => 'create',
                'status_after' => $pengaduan->status,
                'note' => 'Pengaduan dibuat oleh masyarakat publik / Complaints are made by the public.',
                'meta' => [
                    'pelapor_nama' => $pengaduan->pelapor_nama ?? null,
                    'pelapor_contact' => $pengaduan->pelapor_contact ?? null,
                ],
            ]);

            DB::commit();

            return redirect()->route('pengaduan.create')
                ->with('ok', __('pengaduan.thanks_ticket', ['ticket' => '<span class="text-red-600 font-bold">'.e($noTiket).'</span>']));
                // ->with('success', 'Pengaduan Berhasil Dikirim.');
        } catch (\Throwable $e) {
            DB::rollBack();
        
            return back()->withInput()->withErrors(['internal' => 'Terjadi kesalahan. Silakan ulangi.']);
        }
    }

    
    public function track(Request $request)
    {
        $q = trim($request->query('q', ''));

        // basic validation for query param (optional)
        if ($q === '') {
            return view('pengaduan.track', ['pengaduan' => null, 'q' => '']);
        }
        // cari tiket (case-sensitive sesuai data). Jika mau case-insensitive, gunakan lower comparisons.
        $pengaduan = Pengaduan::with(['unit','kategori','jenisLayanan','logs.user'])
            ->where('no_tiket', $q)
            ->first();
        // fallback: bila relasi nama beda, the view will attempt to read safe properties
        return view('pengaduan.track', [
            'pengaduan' => $pengaduan,
            'q' => $q,
        ]);
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'note' => 'nullable|string',
            'dokumen_penyelesaian' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $p = Pengaduan::findOrFail($id);
        $old = $p->status;
        $p->status = $request->status;

        $meta = null;

        if ($request->hasFile('dokumen_penyelesaian')) {
            $file = $request->file('dokumen_penyelesaian');
            $path = $file->store('pengaduan/penyelesaian/'.date('Ymd'), 'public');
            $meta = ['file' => $path, 'name' => $file->getClientOriginalName()];
            // simpan ke kolom dokumen_penyelesaian (array)
            $p->dokumen_penyelesaian = array_merge($p->dokumen_penyelesaian ?? [], [$meta]);
        }

        if ($request->status === 'selesai') {
            $p->tanggal_selesai = now();
        }

        $p->save();

        // catat log (user adalah petugas yang sedang login)
        PengaduanLog::create([
            'pengaduan_id' => $p->id,
            'user_id' => Auth::id(), // pasti ada karena petugas login
            'type' => 'status',
            'status_after' => $p->status,
            'note' => $request->note ?? "Status changed from {$old} to {$p->status}",
            'meta' => $meta,
        ]);

        return back()->with('ok','Status pengaduan diperbarui.');
    }

}

