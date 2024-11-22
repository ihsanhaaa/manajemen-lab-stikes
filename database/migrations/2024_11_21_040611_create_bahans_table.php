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
        Schema::create('bahans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bahan')->nullable();
            $table->string('nama_bahan')->nullable();
            $table->string('formula')->nullable();
            $table->string('exp_bahan')->nullable();
            $table->string('jenis_bahan')->nullable();
            $table->string('satuan')->nullable();
            $table->string('foto_path')->nullable();
            $table->integer('stok_bahan')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahans');
    }
};
