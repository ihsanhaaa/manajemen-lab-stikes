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
        Schema::create('obat_pengajuan_bahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            $table->foreignId('pengajuan_bahan_id')->constrained('pengajuan_bahans')->onDelete('cascade');
            $table->integer('jumlah_pemakaian');
            $table->string('satuan')->nullable();
            $table->string('jenis_obat')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat_pengajuan_bahans');
    }
};
