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
        Schema::create('bahan_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->onDelete('cascade');
            $table->foreignId('bahan_id')->constrained('bahans')->onDelete('cascade');
            $table->integer('jumlah_pemakaian');
            $table->date('tanggal_keluar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_keluars');
    }
};
