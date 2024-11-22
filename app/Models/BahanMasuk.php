<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanMasuk extends Model
{
    use HasFactory;

    protected $table = 'bahan_masuks';
    protected $guarded = ['id'];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }

    public function fotoBahanMasuks()
    {
        return $this->hasMany(FotoBahanMasuk::class, 'bahan_masuk_id');
    }
}
