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
        Schema::create('pengajuan_bahans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mahasiswa')->nullable();
            $table->string('kelompok')->nullable();
            $table->string('kelas')->nullable();
            $table->datetime('tanggal_pelaksanaan')->nullable();
            $table->string('nama_praktikum')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_bahans');
    }
};
