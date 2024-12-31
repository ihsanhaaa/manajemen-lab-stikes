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
        Schema::create('pemakaian_alats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->onDelete('cascade');
            $table->foreignId('user_id');
            $table->string('nama_mahasiswa')->nullable();
            $table->string('nim_kelompok')->nullable();
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
        Schema::dropIfExists('pemakaian_alats');
    }
};
