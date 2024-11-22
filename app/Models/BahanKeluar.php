<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanKeluar extends Model
{
    use HasFactory;

    protected $table = 'bahan_keluars';
    protected $guarded = ['id'];

    public function bahan()
    {
        return $this->belongsTo(Bahan::class);
    }
}
