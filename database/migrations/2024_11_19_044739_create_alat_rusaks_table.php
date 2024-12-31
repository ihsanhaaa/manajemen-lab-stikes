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
        Schema::create('alat_rusaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade');
            $table->string('nama_perusak')->nullable();
            $table->integer('jumlah_rusak');
            $table->date('tanggal_rusak');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Sudah Ganti', 'Belum Ganti'])->default('Belum Ganti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_rusaks');
    }
};
