<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $roles = [
            ['name' => 'admin_upt',    'label' => 'Admin UPT'],
            ['name' => 'admin_layanan', 'label' => 'Admin Layanan'],
            ['name' => 'admin_kanwil', 'label' => 'Admin Kanwil'],
        ];
        foreach ($roles as $r) {
            Role::firstOrCreate(['name' => $r['name']], $r);
        }
    }
}
