<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoBahanMasuk extends Model
{
    use HasFactory;

    protected $table = 'foto_bahan_masuks';
    protected $guarded = ['id'];

    public function fotoBahanMasuks()
    {
        return $this->hasMany(Foto::class, 'bahan_masuk_id');
    }
}
