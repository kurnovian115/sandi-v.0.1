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
        Schema::create('pengaduan_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduans')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // petugas/admin, null kalau publik
            $table->string('type', 50)->default('note'); // create, status, assignment, file, note, complete
            $table->string('status_after')->nullable(); // jika tipe status
            $table->text('note')->nullable();
            $table->json('meta')->nullable(); // tambahan seperti file path, assigned_to, public flag
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengaduan_logs');
    }
};
