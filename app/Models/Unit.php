<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;
    // jangan matikan ini:
    public $timestamps = true;
    protected $fillable = ['name','address','is_active'];
    public function users() { return $this->hasMany(User::class); }
    public function adminUsers()
    {
        return $this->users()
            ->whereRelation('role', 'name', 'admin_upt') // <— join via relasi roles
            ->orderBy('name');
    }
}
