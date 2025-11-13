<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PositiveReview extends Model
{
    use HasFactory;

    protected $table = 'positive_reviews';

    protected $fillable = [
        'pengaduan_id',
        'pelapor_nama',
        'pelapor_contact',
        'email',
        'rating',
        'note',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }
}
