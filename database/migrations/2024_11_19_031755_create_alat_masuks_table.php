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
        Schema::create('alat_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade');
            $table->integer('jumlah_masuk')->default(0);
            $table->date('tanggal_masuk');
            $table->bigInteger('harga_satuan')->default(0);
            $table->bigInteger('total_harga')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alat_masuks');
    }
};
