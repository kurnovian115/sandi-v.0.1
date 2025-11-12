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
    Schema::create('jenis_layanan', function (Blueprint $t) {
        $t->id();
        $t->string('nama')->unique();
         $t->string('nama_en')->unique();
        $t->string('kode')->nullable();
        $t->text('deskripsi')->nullable();
        $t->boolean('is_active')->default(true);       
        $t->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_layanan');
    }
};
