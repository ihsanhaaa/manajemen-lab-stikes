<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    use HasFactory;

    protected $table = 'stok_masuks';
    protected $guarded = ['id'];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }


    // Relasi ke model Foto
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'stok_masuk_id');
    }
}
