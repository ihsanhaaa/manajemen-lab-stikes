<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSurat extends Model
{
    use HasFactory;

    protected $table = 'file_surats';
    protected $guarded = ['id'];

    public function fotoAlatMasuks()
    {
        return $this->hasMany(Foto::class, 'alat_masuk_id');
    }
}
