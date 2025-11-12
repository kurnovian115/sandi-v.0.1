<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengaduan extends Model
{
     use HasFactory;

    protected $table = 'pengaduans';

    protected $fillable = [
        'no_tiket',
        'unit_id',
        'kategori_id',
        'jenis_layanan_id',

        'pelapor_nama',
        'pelapor_contact',

        'asal_pengaduan',

        'judul',
        'deskripsi',

        'bukti_masyarakat',

        'prioritas',
        'status',
        'sla_due_at',
        'sla_late',
        'tanggal_selesai',

        'admin_upt_id',
        'admin_layanan_id',
        'petugas_nama',

        'hasil_tindaklanjut',
        'dokumen_penyelesaian',
    ];

    protected $casts = [
        'bukti_masyarakat' => 'array',
        'dokumen_penyelesaian' => 'array',
        'sla_due_at' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'sla_late' => 'boolean',
    ];

    public function logs()            { return $this->hasMany(PengaduanLog::class, 'pengaduan_id')->latest('id'); }

    public function latestLog()
    {
        return $this->hasOne(PengaduanLog::class)->latestOfMany();
    }

    // relasi
    public function unit() { return $this->belongsTo(Unit::class, 'unit_id'); }
    public function kategori() { return $this->belongsTo(KategoriPengaduan::class, 'kategori_id'); }
    public function jenisLayanan() { return $this->belongsTo(JenisLayanan::class, 'jenis_layanan_id'); }

    public function adminUpt() { return $this->belongsTo(User::class, 'admin_upt_id'); }
    public function adminLayanan() { return $this->belongsTo(User::class, 'admin_layanan_id'); }
    
    // Helper status
    // nilai di DB
    public const STATUS_MENUNGGU  = 'Menunggu';
    public const STATUS_DISPOSISI = 'Disposisi_ke_layanan';
    public const STATUS_SELESAI   = 'Selesai';

     // Label untuk tampilan
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU  => 'Menunggu / Waiting',
            self::STATUS_DISPOSISI => 'Diproses oleh user layanan ',
            self::STATUS_SELESAI   => 'Selesai / Finish',
            default => $this->status,
        };
    }

    // / Warna badge (Tailwind)
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU  => 'bg-amber-50 text-amber-700 border-amber-200',
            self::STATUS_DISPOSISI => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            self::STATUS_SELESAI   => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            default => 'bg-slate-100 text-slate-700 border-slate-200',
        };
    }


}
