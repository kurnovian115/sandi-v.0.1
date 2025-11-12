<?php

namespace App\Models;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Database\Eloquent\Model;

class PengaduanLog extends Model
{
    protected $table = 'pengaduan_logs';
    protected $fillable = ['pengaduan_id','user_id','type','status_after','note','meta'];

    protected $casts = [
        'meta' => 'array'
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
