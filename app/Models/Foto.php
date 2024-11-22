<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;

    protected $table = 'fotos';
    protected $guarded = ['id'];

    public function fotoObatMasuks()
    {
        return $this->hasMany(Foto::class, 'alat_masuk_id');
    }
}
