<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    use HasFactory;

    protected $table = 'stok_keluars';
    protected $guarded = ['id'];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

}
