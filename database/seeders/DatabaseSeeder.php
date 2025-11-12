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
        ]);

        // Buat user Admin Kanwil pertama jika belum ada
    $roleId = Role::where('name', 'admin_kanwil')->value('id');
    // $unitId = Unit::where('type', 'kanwil')->value('id');

    User::firstOrCreate(
        ['nip' => '197912312005011001'],
        [
            'name' => 'Admin Kanwil',
            'email' => 'admin.kanwil@example.com',
            'password' => Hash::make('password'),
            'role_id' => $roleId,
            'unit_id' => '1',
            'is_active' => true,
            'layanan_id' => null,
        ]        
    );
        $roleId = Role::where('name', 'admin_upt')->value('id');
     User::firstOrCreate(
        ['nip' => '197912312005011002'],
        [
            'name' => 'Admin UPT',
            'email' => 'admin.upt@example.com',
            'password' => Hash::make('password'),
            'role_id' => $roleId,
            'unit_id' => '1',
            'is_active' => true,
            'layanan_id' => null,
        ]
     );

    // Pengaduan::factory()->count(10)->create();

    // // minimal data referensi
    // User::factory()->count(2)->create();
    // Unit::factory()->count(1)->create();

    // JenisLayanan::factory()->count(5)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
