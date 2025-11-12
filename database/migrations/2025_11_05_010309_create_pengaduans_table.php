<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('no_tiket')->unique();

            // Tujuan / klasifikasi
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('kategori_id')->nullable()->constrained('kategori_pengaduan')->nullOnDelete();
            $table->foreignId('jenis_layanan_id')->nullable()->constrained('jenis_layanan')->nullOnDelete();

            // Identitas pelapor masyarakat
            $table->string('pelapor_nama')->nullable();
            $table->string('pelapor_contact')->nullable();

            // Asal / sumber pengaduan
            $table->string('asal_pengaduan')->nullable()
                  ->comment('qr, media_sosial, email, telepon, langsung, e-lapor');

            // Isi laporan
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();

            // Lampiran dari masyarakat
            $table->json('bukti_masyarakat')->nullable();

            // Workflow
            $table->string('prioritas',20)->default('rendah');
            $table->string('status',50)->default('menunggu');
            $table->dateTime('sla_due_at')->nullable();
            $table->tinyInteger('sla_late')->default(0);
            $table->dateTime('tanggal_selesai')->nullable();

            // Penanggung jawab internal
            $table->foreignId('admin_upt_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('admin_layanan_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('petugas_nama')->nullable();

            // Hasil tindak lanjut
            $table->text('hasil_tindaklanjut')->nullable();
            $table->json('dokumen_penyelesaian')->nullable();

            $table->timestamps();

            // index untuk kecepatan filter
            $table->index(['unit_id', 'status', 'prioritas']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
