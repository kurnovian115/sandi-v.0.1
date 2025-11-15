<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use App\Models\JenisLayanan;
use App\Models\PengaduanLog;
use Illuminate\Http\Request;
use App\Models\KategoriPengaduan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengaduanEksternalController extends Controller
{
   public function create()
    {
        $title = 'Tambah Pengaduan (Sumber Eksternal)';
        $user = Auth::user();
        $userUnit = $user?->unit_id ? Unit::find($user->unit_id) : null;

        $jenisLayanans = JenisLayanan::orderBy('nama')->get(['id','nama']);
        $kategoris = KategoriPengaduan::orderBy('nama')->get(['id','nama']);

        return view('pengaduan.external.create', compact('title','jenisLayanans','kategoris','userUnit'));
    }

    public function store(Request $request)
    {
        // Jangan percaya input unit_id dari client. Ambil dari user login.
        $user = Auth::user();
        abort_unless($user && $user->unit_id, 403, 'Unit pengguna tidak ditemukan.');

        $validated = $request->validate([
            // 'unit_id' tidak divalidasi dari input — kita set manual dari auth
            'jenis_layanan_id' => ['required','exists:jenis_layanan,id'],

            // Kategori bisa pilih dari daftar atau "lainnya"
            'kategori_id' => ['nullable','integer','exists:kategori_pengaduan,id','required_without:kategori_lainnya'],
            'kategori_lainnya' => ['nullable','string','max:150','required_without:kategori_id'],

            // Sumber eksternal + opsi "Lainnya"
            'asal_pengaduan' => ['required','string','max:100'], // Instagram/Google Review/Lainnya/dll
            'asal_pengaduan_lainnya' => ['nullable','string','max:100','required_if:asal_pengaduan,Lainnya'],
            'sumber_url' => ['nullable','url','max:500'],
            'tanggal_sumber' => ['nullable','date'],

            // Identitas pelapor opsional
            'pelapor_nama' => ['nullable','string','max:150'],
            'pelapor_contact' => ['nullable','string','max:150'],

            'judul' => ['required','string','max:200'],
            'deskripsi' => ['required','string'],

            'bukti_masyarakat.*' => ['nullable','file','max:5120'], // 5 MB per file
        ]);

        // Kunci unit_id ke unit user login
        $validated['unit_id'] = $user->unit_id;

        // Map "asal_pengaduan" jika memilih Lainnya
        if (($validated['asal_pengaduan'] ?? null) === 'Lainnya' && $request->filled('asal_pengaduan_lainnya')) {
            $validated['asal_pengaduan'] = $request->string('asal_pengaduan_lainnya');
        }
        unset($validated['asal_pengaduan_lainnya']);

        // Kategori: jika user isi "kategori_lainnya", buat/take existing kategori otomatis
        if (empty($validated['kategori_id']) && $request->filled('kategori_lainnya')) {
            $katName = trim($request->string('kategori_lainnya'));
            $kategori = KategoriPengaduan::firstOrCreate(['nama' => $katName]);
            $validated['kategori_id'] = $kategori->id;
        }
        unset($validated['kategori_lainnya']);

        // Ticket & status awal
        $validated['no_tiket'] = now()->format('Ymd') . '–EXT-' . strtoupper(Str::random(5));
        $validated['status'] = Pengaduan::STATUS_MENUNGGU;

        // Simpan lampiran
        $paths = [];
        if ($request->hasFile('bukti_masyarakat')) {
            foreach ($request->file('bukti_masyarakat') as $f) {
                $paths[] = $f->store('pengaduan/bukti', config('filesystems.default_public_disk'));
            }
        }
        if ($paths) $validated['bukti_masyarakat'] = $paths;

        // Sisipkan metadata sumber pada deskripsi (opsional)
        $meta = [];
        if ($request->filled('sumber_url')) $meta['URL'] = $request->string('sumber_url');
        if ($request->filled('tanggal_sumber')) $meta['Tanggal Sumber'] = $request->date('tanggal_sumber')->format('d M Y');
        if ($meta) {
            $validated['deskripsi'] = $validated['deskripsi'] . "\n\n—\n(Sumber: " . $validated['asal_pengaduan'] . ")\n" . collect($meta)->map(fn($v,$k)=>"$k: $v")->implode("\n");
        }
        // HATI-HATI: pastikan yang disimpan ke user_id itu benar-benar users.id (integer)
        $userId = optional($user)->id; // <- gunakan kolom `id` numerik
        // Jika model User kamu tidak punya kolom id numerik (pk = NIP), lebih aman jadikan null:
        if (!is_numeric($userId)) {
            $userId = null;
        }

        $pengaduan = Pengaduan::create($validated);
        // Transaksi simpan pengaduan + log
        PengaduanLog::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id'      => $userId,
            'type'         => 'create_external',
            'status_after' => $pengaduan->status,
            'note'         => 'Pengaduan eksternal dibuat',
            'meta'         => [
                'asal_pengaduan' => $validated['asal_pengaduan'],
                'unit_id'        => $validated['unit_id'],
            ],
        ]);

        return redirect()->route('pengaduan.show', $pengaduan->id)
            ->with('success', 'Pengaduan eksternal berhasil ditambahkan.');
    }
}
