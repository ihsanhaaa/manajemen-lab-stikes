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
        Schema::create('konfirmasi_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('tanggal_bayar');
            $table->string('path_bukti_bayar');
            $table->string('keterangan')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfirmasi_pembayarans');
    }
};
