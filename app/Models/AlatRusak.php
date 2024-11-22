<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatRusak extends Model
{
    use HasFactory;

    protected $table = 'alat_rusaks';
    protected $guarded = ['id'];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
}
