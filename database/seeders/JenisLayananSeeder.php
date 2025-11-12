<?php

namespace Database\Seeders;

use App\Models\JenisLayanan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JenisLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisLayanan::insert([
            ['nama'=>'Layanan Paspor','kode'=>'PAS','deskripsi'=>'Pelayanan paspor','is_active'=>true, 'nama_en' => 'Passport Services'],
            ['nama'=>'Layanan Visa','kode'=>'VIS','deskripsi'=>'Pelayanan visa','is_active'=>true,'nama_en' => 'Residence Permit Services'],           
            ['nama'=>'Layanan Izin Tinggal','kode'=>'ITK','deskripsi'=>'Pelayanan Izin Tinggal','is_active'=>true, 'nama_en' => 'Visa Services'],
            // ['nama'=>'Sistem Informasi','kode'=>'TI','deskripsi'=>'Pelayanan Sistem Informasi','is_active'=>true],
            // ['nama'=>'Sarana & Prasarana','kode'=>'SAR','deskripsi'=>'Sarana & Prasarana','is_active'=>true],
        ]);
    }
    
}
