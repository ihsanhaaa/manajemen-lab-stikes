<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $table = 'alats';
    protected $guarded = ['id'];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function alatMasuks()
    {
        return $this->hasMany(AlatMasuk::class);
    }

    public function alatRusaks()
    {
        return $this->hasMany(AlatRusak::class);
    }
}
