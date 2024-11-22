<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semesters';

    protected $guarded = ['id'];

    public function alats()
    {
        return $this->hasMany(Alat::class);
    }
}
