<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPengaduan extends Model
{
    use HasFactory;

    protected $table = 'kategori_pengaduan';

    protected $fillable = [
        'nama',
        'nama_en',
        'kode',
        'deskripsi',
        'is_active', // pastikan ini sama dengan migration
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // relasi ke tabel pengaduan — pakai foreign key yang sesuai migration: kategori_id
    public function complaints()
    {
        return $this->hasMany(Pengaduan::class, 'kategori_id');
    }
}
