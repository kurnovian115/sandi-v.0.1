<?php

namespace Database\Seeders;

use App\Models\JenisLayanan;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\KategoriPengaduan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            UnitSeeder::class,
            JenisLayananSeeder::class,
            KategoriPengaduanSeeder::class,
            UserSeeder::class,
        ]);
      
    }
}
