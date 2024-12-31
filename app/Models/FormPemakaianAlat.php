<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormPemakaianAlat extends Model
{
    use HasFactory;

    protected $table = 'form_pemakaian_alats';
    protected $guarded = ['id'];

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
}
