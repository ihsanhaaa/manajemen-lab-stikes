<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatMasuk extends Model
{
    use HasFactory;

    protected $table = 'alat_masuks';
    protected $guarded = ['id'];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function fotoAlatMasuks()
    {
        return $this->hasMany(FotoAlatMasuk::class, 'alat_masuk_id');
    }
}
