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
        Schema::create('form_pemakaian_alats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('alat_id')->nullable();
            $table->foreignId('pemakaian_alat_id')->constrained('pemakaian_alats')->onDelete('cascade');
            $table->string('ukuran')->nullable();
            $table->bigInteger('jumlah')->default(0);
            $table->bigInteger('jumlah_rusak')->default(0);
            $table->enum('kondisi_pinjam', ['Baik', 'Pecah']);
            $table->enum('kondisi_kembali', ['Baik', 'Pecah']);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_pemakaian_alats');
    }
};
