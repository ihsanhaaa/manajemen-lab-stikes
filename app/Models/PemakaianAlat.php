<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemakaianAlat extends Model
{
    use HasFactory;

    protected $table = 'pemakaian_alats';
    protected $guarded = ['id'];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function alatRusaks()
    {
        return $this->hasMany(AlatRusak::class);
    }

    public function formPemakaianAlats()
    {
        return $this->hasMany(FormPemakaianAlat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
