<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obats';
    protected $guarded = ['id'];

    // Relasi ke model Kemasan
    public function kemasan()
    {
        return $this->belongsTo(Kemasan::class, 'kemasan_id');
    }

    // Relasi ke model BentukSediaan
    public function bentukSediaan()
    {
        return $this->belongsTo(BentukSediaan::class, 'bentuk_sediaan_id');
    }

    // Relasi ke model Satuan
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function stokMasuks()
    {
        return $this->hasMany(StokMasuk::class);
    }

    public function stokKeluars()
    {
        return $this->hasMany(StokKeluar::class);
    }

}
