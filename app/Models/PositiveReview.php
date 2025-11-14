<?php

namespace App\Models;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PositiveReview extends Model
{
     use HasFactory;

    protected $table = 'positive_reviews';

    protected $fillable = [
        'pengaduan_id',
        'upt_id',
        'jenis_layanan_id',
        'pelapor_nama',
        'pelapor_contact',
        'email',
        'rating',
        'note',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'rating' => 'integer',
    ];

    // relasi (jika model Unit / JenisLayanan ada)
    public function upt()
    {
        if (class_exists(Unit::class)) {
            return $this->belongsTo(Unit::class, 'upt_id');
        }

        return null;
    }

    public function jenisLayanan()
    {
        if (class_exists(JenisLayanan::class)) {
            return $this->belongsTo(JenisLayanan::class, 'jenis_layanan_id');
        }

        return null;
    }
}
