<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriPengaduan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriPengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         KategoriPengaduan::insert([
            ['nama'=>'Pengaduan terhadap Petugas','kode'=>'PET','deskripsi'=>'Laporan perilaku petugas','is_active'=>true, 'nama_en' => 'Complaints against Officers'],
            ['nama'=>'Pengaduan terhadap Proses Layanan','kode'=>'PRO','deskripsi'=>'Masalah alur & prosedur layanan','is_active'=>true, 'nama_en' => 'Complaints about the Service Process'],
            ['nama'=>'Sarana & Prasarana','kode'=>'SAR','deskripsi'=>'Keluhan fasilitas kantor','is_active'=>true, 'nama_en' => 'Facilities & infrastructure'],
            ['nama'=>'Sistem / Aplikasi','kode'=>'SYS','deskripsi'=>'Error aplikasi dan TI','is_active'=>true, 'nama_en' => 'System / Application'],
            ['nama'=>'Lainnya','kode'=>'LNS','deskripsi'=>'Pengaduan umum lain','is_active'=>true, 'nama_en' => 'Others'],
        ]);
        
    }
}
