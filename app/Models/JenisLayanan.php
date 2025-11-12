<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisLayanan extends Model
{
    use HasFactory;
    protected $table = 'jenis_layanan';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'is_active',
        'nama_en'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'layanan_id');
    }
}
