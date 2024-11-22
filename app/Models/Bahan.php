<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    protected $table = 'bahans';
    protected $guarded = ['id'];

    public function bahanMasuks()
    {
        return $this->hasMany(BahanMasuk::class);
    }

    public function bahanKeluars()
    {
        return $this->hasMany(BahanKeluar::class);
    }
}
