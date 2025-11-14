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
        if (! Schema::hasTable('positive_reviews')) {
            // jika table belum ada, jangan jalankan migrasi ini — pastikan model/table exist terlebih dahulu
            return;
        }

        Schema::table('positive_reviews', function (Blueprint $table) {
            // gunakan unsignedBigInteger untuk konsistensi dengan PK modern (users, units, etc.)
            $table->unsignedBigInteger('upt_id')->nullable()->after('id')->index();
            $table->unsignedBigInteger('jenis_layanan_id')->nullable()->after('upt_id')->index();

            // Optional: tambahkan foreign key jika tabel terkait pasti ada.
            // Jika kamu tidak yakin, biarkan baris berikut dikomentari.
            // $table->foreign('upt_id')->references('id')->on('units')->onDelete('set null');
            // $table->foreign('jenis_layanan_id')->references('id')->on('jenis_layanans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('positive_reviews')) {
            return;
        }

        Schema::table('positive_reviews', function (Blueprint $table) {
            // jika FK ditambahkan, harus dropForeign sebelum dropColumn
            // $table->dropForeign(['upt_id']);
            // $table->dropForeign(['jenis_layanan_id']);
            $table->dropColumn(['upt_id', 'jenis_layanan_id']);
        });
    }
};
