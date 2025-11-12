<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'Kantor Imigrasi Kelas I TPI Bandung', 'address' => 'Jl. Surapati No.82, Cihaur Geulis, Kec. Cibeunying Kaler, Kota Bandung, Jawa Barat 40122', 'is_active' => true],
            // ['name' => 'Kantor Imigrasi Kelas II Non TPI Sukabumi', 'address' => 'Tasikmalaya', 'is_active' => true],
            // ['name' => 'Kantor Imigrasi Kelas I Non TPI Bogor', 'address' => 'Cirebon', 'is_active' => true],
            // ['name' => 'Kantor Imigrasi Kelas I Non TPI Depok', 'address' => 'Cirebon', 'is_active' => true],
            // ['name' => 'Kantor Imigrasi Kelas I Non TPI Tasikmalaya', 'address' => 'Cirebon', 'is_active' => true,],
            // ['name' => 'Kantor Imigrasi Kelas III Non TPI Cianjur', 'address' => 'Cirebon', 'is_active' => true],
            // ['name' => 'Kantor Imigrasi Kelas I Non TPI Karawang', 'address' => 'Cirebon', 'is_active' => true],
            // ['name' => 'Kantor Imigrasi Kelas I TPI Cirebon', 'address' => 'Cirebon', 'is_active' => true],
            // ['name' => 'Kantor Imigrasi Kelas I Non TPI Bekasi', 'address' => 'Cirebon', 'is_active' => true],
            // ['name' => 'Kanwil Imigrasi Jawa Barat', 'type' => 'kanwil', 'city' => 'Bandung', 'is_active' => true],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(['name' => $unit['name']], $unit);
        }
    }
}
