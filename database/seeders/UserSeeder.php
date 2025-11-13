<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleId = Role::where('name', 'admin_kanwil')->value('id');
        $users = [
    ];
        User::insert([
            ['nip' => '197912312005011001',
                'name' => 'Admin Kanwil',
                'email' => 'admin.kanwil@example.com',
                'password' => Hash::make('password'),
                'role_id' => $roleId,
                'unit_id' => null,
                'is_active' => true,
                'layanan_id' => null,
                'created_at' => now(),
            ],
            ['nip' => '197109241994031001',
                'name' => 'Tedi Hartadi Wibowo',
                'email' => 'admin.kanwil@example.com',
                'password' => Hash::make('wibowo'),
                'role_id' => $roleId,
                'unit_id' => null,
                'is_active' => true,
                'layanan_id' => null,
                'created_at' => now(),
            ],
            // admin UPT
            ['nip' => '197912312005011002',
                'name' => 'Admin UPT',
                'email' => 'admin.upt@example.com',
                'password' => Hash::make('password'),
                'role_id' => $roleId,
                'unit_id' => 1,
                'is_active' => true,
                'layanan_id' => null,
                'created_at' => now(),
            ],
                
        ]);

      
    }
}
