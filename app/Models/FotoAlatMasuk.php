<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoAlatMasuk extends Model
{
    use HasFactory;

    protected $table = 'foto_alat_masuks';
    protected $guarded = ['id'];

    public function fotoAlatMasuks()
    {
        return $this->hasMany(Foto::class, 'alat_masuk_id');
    }
}
